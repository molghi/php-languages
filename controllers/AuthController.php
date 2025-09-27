<?php

    class AuthController {

        public function logout () {
            $_SESSION = []; // clear all session variables
            session_destroy();
        }

        // ===============================================================

        private function redirect_with_error (string $msg_type, string $msg, string $page) {
            $_SESSION[$msg_type] = $msg;
            header("Location: $page");
            exit();
        }

    }