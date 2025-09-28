<?php

    declare(strict_types=1);

    class Database {

        private $host = 'localhost';
        private $user = 'root';
        private $pw = '';
        private $db_name = 'php_languages';

        // private $host = '';
        // private $user = '';
        // private $pw = '';
        // private $db_name = '';

        private $pdo;

        public function __construct() {
            // $this->host = getenv('DB_HOST');
            // $this->user = getenv('DB_USER');
            // $this->pw   = getenv('DB_PASS');
            // $this->db_name = getenv('DB_NAME');

            $this->pdo_conn();
        }

        // ================================================================================================

        // make pdo instance
        public function pdo_conn () {
            try {
                $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->db_name;charset=utf8", $this->user, $this->pw);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }    

        // ================================================================================================

        public function add_word ($word, $translation, $language, $category, $example, $notes, $user_id) {
            try {
                $sql = 'INSERT INTO words (word, translation, language, category, example, notes, user_id) 
                    VALUES (:word, :translation, :language, :category, :example, :notes, :user_id)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":word", $word);
            $stmt->bindParam(":translation", $translation);
            $stmt->bindParam(":language", $language);
            $stmt->bindParam(":category", $category);
            $stmt->bindParam(":example", $example);
            $stmt->bindParam(":notes", $notes);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->execute();
            } catch (PDOException $e) {
                // Handle or log error
                error_log("Add word failed: " . $e->getMessage());
                echo "Add word failed: " . $e->getMessage();
                return false;
            }
        }

        // ================================================================================================

        public function get_user_words ($user_id) {
            $sql = 'SELECT * FROM words WHERE user_id = ? ORDER BY created_at DESC';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$user_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // ================================================================================================

        public function get_user_words_filtered ($user_id, $lang, $cat) {
            if ($lang === 'all' && $cat === 'all') {
                $sql = 'SELECT * FROM words WHERE user_id = :user_id ORDER BY created_at DESC';
            }
            elseif ($cat === 'all') {
                $sql = 'SELECT * FROM words WHERE user_id = :user_id AND language = :language ORDER BY created_at DESC';
            }
            elseif ($lang === 'all') {
                $sql = 'SELECT * FROM words WHERE user_id = :user_id AND category = :category ORDER BY created_at DESC';
            }
            else {
                $sql = 'SELECT * FROM words WHERE user_id = :user_id AND language = :language AND category = :category ORDER BY created_at DESC';
            }

            $stmt = $this->pdo->prepare($sql);
            
            $stmt->bindParam(":user_id", $user_id);
            if ($lang !== 'all') { $stmt->bindParam(":language", $lang); }
            if ($cat !== 'all') { $stmt->bindParam(":category", $cat); }
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // ================================================================================================

        public function delete_word ($user_id, $word_id) {
            $sql = 'DELETE FROM words WHERE user_id = ? AND id = ?';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$user_id, $word_id]);
        }

        // ================================================================================================

        public function get_user_word ($user_id, $word_id) {
            $sql = 'SELECT * FROM words WHERE user_id = ? AND id = ? LIMIT 1';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$user_id, $word_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // ================================================================================================

        public function edit_word ($word, $translation, $language, $category, $example, $notes, $user_id, $word_id) {
            $sql = 'UPDATE words SET word = :word, translation = :translation, language = :language, category = :category, example = :example, notes = :notes 
                    WHERE user_id = :user_id AND id = :word_id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":word", $word);
            $stmt->bindParam(":translation", $translation);
            $stmt->bindParam(":language", $language);
            $stmt->bindParam(":category", $category);
            $stmt->bindParam(":example", $example);
            $stmt->bindParam(":notes", $notes);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":word_id", $word_id);
            $stmt->execute();
        }

        // ================================================================================================

        public function fetch_word_set ($user_id, $lang, $cat) {
            $sql = "SELECT * FROM words WHERE user_id = :user_id AND (next_revision <= NOW() OR next_revision IS NULL) "; 

            if ($lang !== 'all') {
                $sql .= ' AND language = :language';
            }
            if ($cat !== 'all') {
                $sql .= ' AND category = :category';
            }

            $sql .= ' ORDER BY RAND() LIMIT 10'; // fetch 10 random rows
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":user_id", $user_id);
            if ($lang !== 'all') { $stmt->bindParam(":language", $lang); }
            if ($cat !== 'all') { $stmt->bindParam(":category", $cat); }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // ================================================================================================

        public function update_words_strength ($user_id, $strengths, $word_ids, $next_revision_dates) {
            $sql = 'UPDATE words SET strength = CASE id ';

            $ids = '';

            foreach($strengths as $k => $v) {
                $sql .= "WHEN $word_ids[$k] THEN $v ";
                $ids .= "$word_ids[$k], ";
            }

            $ids = rtrim($ids, ', '); // slicing off the last ', '

            $sql .= ' END, next_revision = CASE id ';
            foreach($next_revision_dates as $id => $nrd) {
                $sql .= " WHEN $id THEN '$nrd' "; // SQL TIMESTAMP/DATETIME literals must be wrapped in single quotes
            }
            
            $sql .= " END WHERE user_id = ? AND id IN ($ids)";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$user_id]);
        }

        // ================================================================================================

        // check if username or email already exist in db
        public function email_exists (string $email): bool {
            $email = trim($email);
            $result = false;

            $sql = 'SELECT * FROM users WHERE email = ? LIMIT 1';      // limit to 1 record since I care only about "> 0"
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$email]);
            
            $fetched = $stmt->fetch(PDO::FETCH_ASSOC);    // fetch one
            if ($fetched) { $result = true; }

            return $result;
        }

        // ================================================================================================

        public function create_user (string $username, string $email, string $password) {
            $sql = 'INSERT INTO users (username, email, password) VALUES (:username, :email, :password)';
            $stmt = $this->pdo->prepare($sql);

            if ($username === '') {
                $username = trim(explode('@', $email)[0]);
            }

            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $password);
            $stmt->execute();

            return $this->pdo->lastInsertId(); // return the auto-increment ID -- get the newly created user ID
        }  

        // ================================================================================================

        // check if username or email exists in db
        public function check_username_email (string $usernameEmail): bool {
            $sql = 'SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1'; // limit to 1 since I only care if it's more than 0
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$usernameEmail, $usernameEmail]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? true : false; // return true if exists in db, false if doesn't
        }

        // ================================================================================================

        // on login: check if typed pw was correct
        public function check_password ($username_or_email, $typed_pw): bool {
            $sql = 'SELECT password FROM users WHERE username = ? OR email = ?';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$username_or_email, $username_or_email]);

            $fetched_pw = $stmt->fetchColumn(); // fetch the password hash directly, the string directly

            $check_result = password_verify($typed_pw, $fetched_pw); // password_verify compares PLAIN pw to STORED HASH and returns boolean

            return $check_result;
        }

        // ================================================================================================

        // get user id
        public function get_user_id ($username_or_email) {   
            $sql = 'SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$username_or_email, $username_or_email]);

            $fetched_id = $stmt->fetchColumn(); // fetch id directly, just the string

            return $fetched_id;
        }

        // ================================================================================================

        public function get_profile ($user_id) {
            $sql = 'SELECT username, email FROM users WHERE id = ? LIMIT 1';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$user_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // ================================================================================================

        public function get_words_count ($user_id) {
            $sql = 'SELECT COUNT(*) FROM words WHERE user_id = ?';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$user_id]);
            return $stmt->fetchColumn();
        }

        // ================================================================================================

        public function get_next_review ($user_id) {
            $sql = 'SELECT next_revision FROM words WHERE user_id = ? ORDER BY next_revision ASC LIMIT 1';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$user_id]);
            return $stmt->fetchColumn();
        }

        // ================================================================================================

        public function get_words_count_to_review ($user_id) {
            $sql = 'SELECT COUNT(*) AS words_to_review, language AS lang FROM words WHERE user_id = ? AND (next_revision <= NOW() OR next_revision IS NULL) GROUP BY language';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$user_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // ================================================================================================

        public function get_lang_count ($user_id) {
            // $sql = 'SELECT DISTINCT language AS langs, COUNT(DISTINCT language) AS langcount FROM words WHERE user_id = ?'; 
            $sql = 'SELECT COUNT(*) AS total_words FROM words WHERE user_id = ?'; 
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$user_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // ================================================================================================

        public function get_added_langs ($user_id) {
            $sql = 'SELECT DISTINCT language FROM words WHERE user_id = ?';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$user_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // ================================================================================================

        public function get_words_in_rotation ($user_id) {
            $sql = 'SELECT COUNT(*) FROM words WHERE user_id = ? AND strength IN (0, 1, 2)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$user_id]);
            return $stmt->fetchColumn();
        }

        // ================================================================================================

        public function get_words_learned ($user_id) {
            $sql = 'SELECT COUNT(*) FROM words WHERE user_id = ? AND strength IN (3, 4)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$user_id]);
            return $stmt->fetchColumn();
        }

        // ================================================================================================

        public function push_new_session ($user_id) {
            $sql = 'INSERT INTO sessions (user_id) VALUES (?)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$user_id]);
        }

        // ================================================================================================

        public function get_sessions_played_today ($user_id) {
            $sql = 'SELECT COUNT(*) FROM sessions WHERE user_id = ? AND DATE(played_at) = CURDATE()';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$user_id]);
            return $stmt->fetchColumn();
        }

        // ================================================================================================

        public function get_prev_played_day ($user_id) {
            $sql = 'SELECT * FROM sessions WHERE user_id = ? AND DATE(played_at) < CURDATE() ORDER BY played_at DESC LIMIT 1';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$user_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
            // returns false if no row is found
        }

        // ================================================================================================

        public function get_lang_stats ($user_id) {
            // $sql = 'SELECT COUNT(*) AS total_words, language, strength FROM words WHERE user_id = ? GROUP BY language, strength';   // this works but counts per strength, not per language
            $sql = 'SELECT COUNT(*) AS total_words, language,
                    SUM(strength = 0) AS untested,
                    SUM(strength = 1) AS weak,
                    SUM(strength = 2) AS medium,
                    SUM(strength = 3) AS strong,
                    SUM(strength = 4) AS mastered 
                FROM words WHERE user_id = ? GROUP BY language ORDER BY total_words DESC';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$user_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    }