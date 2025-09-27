<?php

    class WordController {

        private $form_page = '../public/form.php';
        private $form_error_code = 'form_error';
        private $vocab_page = '../public/vocabulary.php';
        private $quiz_page = '../public/quiz.php';

        // ========================================================================

        public function add_word () {
            global $val; // validator class instance
            global $db;   // database class instance

            // get form data
            $word = trim($_POST['word']);
            $translation = trim($_POST['translation']);
            $language = trim($_POST['language']);
            $category = trim($_POST['category']);
            $example = trim($_POST['example']);
            $notes = trim($_POST['notes']);

            // echo $word; echo "<br>"; echo $translation; echo "<br>"; echo $language; echo "<br>"; echo $category; echo "<br>"; echo $example; echo "<br>"; echo $notes;

            // validate
            $has_empty_field = $val->has_empty_field([$word, $translation, $language, $category]);
            if ($has_empty_field) {
                $this->pass_form_data($word, $translation, $language, $category, $example, $notes);
                $this->redirect_with_error($this->form_error_code, 'Fields <i>word</i>, <i>translation</i>, <i>language</i> & <i>category</i> must not be empty!', $this->form_page);
            }

            $is_word_not_too_long = $val->is_text_not_too_long($word); // not longer than 255 chars
            if (!$is_word_not_too_long) {
                $this->pass_form_data($word, $translation, $language, $category, $example, $notes);
                $this->redirect_with_error($this->form_error_code, 'Field <i>word</i> is too long!', $this->form_page);
            }

            $is_translation_not_too_long = $val->is_text_not_too_long($translation); // not longer than 255 chars
            if (!$is_translation_not_too_long) {
                $this->pass_form_data($word, $translation, $language, $category, $example, $notes);
                $this->redirect_with_error($this->form_error_code, 'Field <i>translation</i> is too long!', $this->form_page);
            }

            $is_example_not_very_long = $val->is_text_not_super_long($example); // not longer than 1000 chars
            if (!$is_example_not_very_long) {
                $this->pass_form_data($word, $translation, $language, $category, $example, $notes);
                $this->redirect_with_error($this->form_error_code, 'Field <i>example</i> is excessively long!', $this->form_page);
            }

            $is_notes_not_very_long = $val->is_text_not_super_long($notes); // not longer than 1000 chars
            if (!$is_notes_not_very_long) {
                $this->pass_form_data($word, $translation, $language, $category, $example, $notes);
                $this->redirect_with_error($this->form_error_code, 'Field <i>notes</i> is excessively long!', $this->form_page);
            }

            // add to db
            $user_id = 1;
            $db->add_word($word, $translation, $language, $category, $example, $notes, $user_id);
            $_SESSION['last_entered_lang'] = $language;
            $_SESSION['last_entered_cat'] = $category;
            unset($_SESSION['form_data']);

            // redirect to vocab page
            header("Location: $this->vocab_page");
        }

        // ========================================================================

        private function redirect_with_error (string $msg_type, string $msg, string $page) {
            $_SESSION[$msg_type] = $msg;
            header("Location: $page");
            exit();
        }

        // ========================================================================

        private function pass_form_data ($word, $translation, $language, $category, $example, $notes) {
            $_SESSION['form_data'] = [
                    'word' => $word,
                    'translation' => $translation,
                    'language' => $language,
                    'category' => $category,
                    'example' => $example,
                    'notes' => $notes,
                ];
        }

        // ========================================================================

        public function delete_word ($user_id, $word_id) {
            global $db;
            global $val;

            // validate
            $has_empty_field = $val->has_empty_field([(string) $user_id, $word_id]);
            if ($has_empty_field) {
                $this->redirect_with_error('deletion_error', 'Empty fields not allowed!', $this->vocab_page);
            }

            $db->delete_word($user_id, $word_id);

            header("Location: $this->vocab_page");
        }

        // ========================================================================
        
        public function edit_word ($user_id, $word_id) {
            global $val;  // validator class instance
            global $db;    // database class instance

            // grab data
            $word = trim($_POST['word']);
            $translation = trim($_POST['translation']);
            $language = trim($_POST['language']);
            $category = trim($_POST['category']);
            $example = trim($_POST['example']);
            $notes = trim($_POST['notes']);

            // validate
            $has_empty_field = $val->has_empty_field([$word, $translation, $language, $category]);
            if ($has_empty_field) {
                $this->pass_form_data($word, $translation, $language, $category, $example, $notes);
                $this->redirect_with_error($this->form_error_code, 'Fields <i>word</i>, <i>translation</i>, <i>language</i> & <i>category</i> must not be empty!', $this->form_page);
            }

            $is_word_not_too_long = $val->is_text_not_too_long($word); // not longer than 255 chars
            if (!$is_word_not_too_long) {
                $this->pass_form_data($word, $translation, $language, $category, $example, $notes);
                $this->redirect_with_error($this->form_error_code, 'Field <i>word</i> is too long!', $this->form_page);
            }

            $is_translation_not_too_long = $val->is_text_not_too_long($translation); // not longer than 255 chars
            if (!$is_translation_not_too_long) {
                $this->pass_form_data($word, $translation, $language, $category, $example, $notes);
                $this->redirect_with_error($this->form_error_code, 'Field <i>translation</i> is too long!', $this->form_page);
            }

            $is_example_not_very_long = $val->is_text_not_super_long($example); // not longer than 1000 chars
            if (!$is_example_not_very_long) {
                $this->pass_form_data($word, $translation, $language, $category, $example, $notes);
                $this->redirect_with_error($this->form_error_code, 'Field <i>example</i> is excessively long!', $this->form_page);
            }

            $is_notes_not_very_long = $val->is_text_not_super_long($notes); // not longer than 1000 chars
            if (!$is_notes_not_very_long) {
                $this->pass_form_data($word, $translation, $language, $category, $example, $notes);
                $this->redirect_with_error($this->form_error_code, 'Field <i>notes</i> is excessively long!', $this->form_page);
            }

            // push to db
            $db->edit_word($word, $translation, $language, $category, $example, $notes, $user_id, $word_id);
            
            // redir
            header("Location: $this->vocab_page");
        }
        
        // ========================================================================

        public function get_word_set ($user_id, $lang, $cat) {
            global $db;

            $fetched_entries = $db->fetch_word_set($user_id, $lang, $cat);

            if (count($fetched_entries) > 0) {
                $_SESSION['quiz_set'] = $fetched_entries;
                $_SESSION['quiz_params'] = [$lang, $cat];
                $_SESSION['quiz_round'] = $round = 1;
                $_SESSION['quiz_answers'] = [];
    
                header("Location: $this->quiz_page" . "?lang=$lang&cat=$cat&round=$round");
            } else {
                $_SESSION['quiz_msg'] = [$lang, $cat];
                // header("Location: $this->quiz_page" . "?error=nowords");
                header("Location: $this->quiz_page");
            }

        }

        // ========================================================================

        public function next_round () {
            $current_round = (int) $_SESSION['quiz_round']; // not zero based
            $total_rounds = count($_SESSION['quiz_set']); // zero based
            $next_round = $current_round + 1;

            if ($next_round-1 < $total_rounds) {
                // within bounds: next round
                $_SESSION['quiz_round'] = $next_round;
                $lang = $_SESSION['quiz_params'][0];
                $cat = $_SESSION['quiz_params'][1];
                $round_answer = $_POST['answer'];
                array_push($_SESSION['quiz_answers'], $round_answer);
                header("Location: $this->quiz_page" . "?lang=$lang&cat=$cat&round=$next_round");
            } 
            
            else {
                // out of bounds: quiz finished
                $round_answer = $_POST['answer'];
                array_push($_SESSION['quiz_answers'], $round_answer);
                header("Location: $this->quiz_page" . "?action=quizdone");
            }
        }

        // ========================================================================

        public function register_quiz ($user_id) {
            global $db;

            // get data
            $quiz_answers = array_values($_POST);

            // form final data arrays
            $strengths = [];
            foreach($quiz_answers as $i) {
                if ($i === 'weak') array_push($strengths, 1);
                if ($i === 'medium') array_push($strengths, 2);
                if ($i === 'strong') array_push($strengths, 3);
                if ($i === 'mastered') array_push($strengths, 4);
            }

            $word_ids = [];
            foreach($_SESSION['quiz_set'] as $i) {
                array_push($word_ids, (int) $i['id']);
            }

            $next_revision_dates = [];
            date_default_timezone_set('Etc/GMT-4');
            foreach($strengths as $key => $val) {
                if ($val === 1) $revision_date = date("Y-m-d H:i:s", strtotime('+25 minutes'));  // weak
                if ($val === 2) $revision_date = date("Y-m-d H:i:s", strtotime('+6 hours'));     // medium
                if ($val === 3) $revision_date = date("Y-m-d H:i:s", strtotime('+3 days'));      // strong
                if ($val === 4) $revision_date = date("Y-m-d H:i:s", strtotime('+10 days'));     // mastered
                $next_revision_dates[$word_ids[$key]] = $revision_date;
            }

            // run query to upd strength of each word
            $db->update_words_strength($user_id, $strengths, $word_ids, $next_revision_dates);

            // unset sesh vars
            unset($_SESSION['quiz_set']);
            unset($_SESSION['quiz_params']);
            unset($_SESSION['quiz_round']);
            unset($_SESSION['quiz_answers']);

            $_SESSION['quiz_msg'] = "<strong>Message:</strong> Your quiz results have been registered!";
            header("Location: $this->vocab_page");
        }

        // ========================================================================
    }