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
?>


<!-- IMPORT SITE HEADER -->
<?php require_once('../views/header.php'); ?>



<!-- IMPORT MAIN PAGE CONTENT -->
<?php require_once('../views/vocab_block.php'); ?>



<!-- IMPORT SITE FOOTER -->
<?php require_once('../views/footer.php'); ?>