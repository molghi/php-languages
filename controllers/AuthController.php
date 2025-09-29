<?php

    class AuthController {

        private $index_page = '../public/index.php';
        private $auth_page = '../public/auth.php';
        private $vocab_page = '../public/vocabulary.php';

        public function logout () {
            $_SESSION = []; // clear all session variables
            unset($_SESSION['user_id']);
            session_destroy();
            header("Location: $this->index_page"); 
            exit();
        }

        // ===============================================================

        private function redirect_with_error (string $msg_type, string $msg, string $page) {
            $_SESSION[$msg_type] = $msg;
            header("Location: $page");
            exit();
        }

        // ===============================================================

        public function signup () {
            global $db;
            global $val;

            // get form data
            // $username = trim($_POST['username']);
            $email = strtolower(trim($_POST['email']));
            $password = trim($_POST['password']);
            $password_repeat = trim($_POST['password-repeat']);

            // VALIDATE

            // check that all fields are filled
            $has_empty_field = $val->has_empty_field([$email, $password, $password_repeat]);
            if ($has_empty_field) { 
                $this->redirect_with_error('auth_error', 'Fill out all fields!', $this->auth_page);
            }

            // check that pw's long enough & match
            $are_passwords_good = $val->are_passwords_good($password, $password_repeat);
            if (!$are_passwords_good) {
                $this->redirect_with_error('auth_error', 'Passwords must match & be at least 3 chars long!', $this->auth_page);
            }
            
            // check valid username: doesnt start with num, not too long
            // $is_username_valid = $val->is_username_valid($username);
            // if (!$is_username_valid) {
            //     $this->redirect_with_error('auth_error', 'Username mustn\'t start with a number or be longer than 25 chars!', $this->auth_page);
            // }
            
            // check valid email
            $is_email_valid = $val->is_email_valid($email);
            if (!$is_email_valid) {
                $this->redirect_with_error('auth_error', 'Email must be a valid email!', $this->auth_page);
            }

            // check if username & email exist in db 
            $email_exists = $db->email_exists($email);
            if ($email_exists) {
                $this->redirect_with_error('auth_error', 'That email is already used!', $this->auth_page);
            }

            // if all good, run query to make new entry in db --> in 'users' table -- and hash pw
            $hashed_pw = password_hash($password, PASSWORD_DEFAULT);
            $user_id = $db->create_user('', $email, $hashed_pw);   // create user returns new user id
            
            unset($_SESSION['auth_error']);

            // log user in -- set some token & render sth different
            $_SESSION['user_id'] = $user_id;                                                  // set some token
            header("Location: $this->vocab_page"); 
            exit();
        }

        // ================================================================================================================

        public function login () {
            global $db;
            global $val;

            // get form data -- no need to sanitize cuz Im not outputting to browser
            $email = strtolower(trim($_POST['email']));
            $password = trim($_POST['password']);

            // check if $email exists in db
            $user_exists = $db->check_username_email($email);
            if (!$user_exists) {   // if not, return error 
                $this->redirect_with_error('auth_error', 'Username or email doesn\'t exist in the database!', $this->auth_page);
            }

            // if exists, check pw
            $is_password_correct = $db->check_password($email, $password);
            if (!$is_password_correct) { 
                $this->redirect_with_error('auth_error', 'Invalid credentials!', $this->auth_page);
            }
            
            // if all good, log 'em in
            unset($_SESSION['auth_error']);
            $user_id = $db->get_user_id($email);         // query db, get only user id
            $_SESSION['user_id'] = $user_id;                         // set some token
            header("Location: $this->vocab_page");  
            echo 'logged';
            exit();
        }

    }