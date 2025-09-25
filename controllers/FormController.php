<?php

    class FormController {

        private $form_page = '../public/form.php';
        private $form_error_code = 'form_error';
        private $vocab_page = '../public/index.php';

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

    }