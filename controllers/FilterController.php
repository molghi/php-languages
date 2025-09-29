<?php

    class FilterController {

        private $vocab_page = '../public/vocabulary.php';
        private $error_code = 'filter_error';

        public function filter ($user_id) {
            global $val;
            global $db;
            global $languages;
            global $categories;

            // get form data
            $lang = $_POST['language'];
            $cat  = $_POST['category'];
            // var_dump($cat);
            echo $lang;
            echo "<br>";
            echo "<br>";
            echo $cat;
            

            // VALIDATION
            // check if not empty
            $has_empty_field = $val->has_empty_field([$lang, $cat]);
            if ($has_empty_field) {
                $this->redirect_with_error($this->error_code, 'Fields language and category cannot be empty!', $this->vocab_page);
            }

            // check if matches existing langs
            $permitted_langs = array_keys($languages);
            array_push($permitted_langs, 'all');
            if (!in_array($lang, $permitted_langs)) {
                $this->redirect_with_error($this->error_code, 'Language not found!', $this->vocab_page);
            }

            // check if matches existing cats
            $added_categories = $db->get_added_categories($user_id);
            $added_categories_clean = [];
            foreach($added_categories as $i) {  array_push($added_categories_clean, $i['category']);  }
            $permitted_cats = $added_categories_clean;
            echo "<br>";
            echo "<br>";
            print_r($permitted_cats);
            array_push($permitted_cats, 'all');
            echo "<br>";
            echo "<br>";
            echo !in_array($cat, $permitted_cats) ? 'true' : 'false';
            // exit;
            if (!in_array($cat, $permitted_cats)) {
                $this->redirect_with_error($this->error_code, 'Category not found!', $this->vocab_page);
            }

            // if all good, run db query & render it
            $_SESSION['filter'] = [$lang, $cat];
            header("Location: $this->vocab_page");
        }

        // ===============================================================

        private function redirect_with_error (string $msg_type, string $msg, string $page) {
            $_SESSION[$msg_type] = $msg;
            header("Location: $page");
            exit();
        }

    }