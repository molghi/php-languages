<?php

    require_once('../includes/init.php');

    // passing things to header.php
    $doc_title = 'PHP Vocab Trainer: Vocabulary';
    $page = 'vocabulary';

    require_once('../includes/Database.php');
    $db = new Database;
    
    $is_filter_on = isset($_SESSION['filter']) ? true : false;
    if ($is_filter_on) {
        $lang = $_SESSION['filter'][0];
        $cat = $_SESSION['filter'][1];
        $user_words = $db->get_user_words_filtered($user_id, $lang, $cat);
    } else {
        $user_words = $db->get_user_words($user_id);
    }

    function get_time_interval ($timestamp) {
        date_default_timezone_set('Etc/GMT-4');
        $now = time();
        $then = strtotime($timestamp);
        $diff = floor(($then - $now)/60/60); // in hrs
        if ($diff > 23) {
            $diff = floor($diff / 24); // in days
            $diff = '~' . $diff . ' days';
        } else $diff = '~' . $diff . ' hrs';
        return $diff;
    }
?>


<!-- IMPORT SITE HEADER -->
<?php require_once('../views/header.php'); ?>



<!-- IMPORT MAIN PAGE CONTENT -->
<?php require_once('../views/vocab_block.php'); ?>



<!-- IMPORT SITE FOOTER -->
<?php require_once('../views/footer.php'); ?>