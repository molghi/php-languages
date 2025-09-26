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
            $sql = 'SELECT * FROM words WHERE user_id = :user_id'; 

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

        public function update_words_strength ($user_id, $strengths, $word_ids) {
            $sql = 'UPDATE words SET strength = CASE id ';

            $ids = '';

            foreach($strengths as $k => $v) {
                $sql .= "WHEN $word_ids[$k] THEN $v ";
                $ids .= "$word_ids[$k], ";
            }

            $ids = rtrim($ids, ', '); // slicing off the last ', '
            
            $sql .= "END WHERE user_id = ? AND id IN ($ids)";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$user_id]);
        }

        // ================================================================================================

    }