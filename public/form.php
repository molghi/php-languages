<?php

    require_once('../includes/init.php');

    $mode = 'add';

    $form_data = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : null;

    if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'edit') {
        $mode = 'edit';
        require_once('../includes/Database.php');
        $db = new Database;
        $word_id = $_REQUEST['wordid'];
        $word_to_edit = $db->get_user_word($user_id, $word_id);
    }

    $page = 'form';

    // passing things to header.php
    $doc_title = 'PHP Vocab Trainer: Add Word';
    if ($mode === 'edit') $doc_title = 'PHP Vocab Trainer: Edit Word';

?>


<!-- IMPORT SITE HEADER -->
<?php require_once('../views/header.php'); ?>



<!-- IMPORT MAIN PAGE CONTENT -->
<?php require_once('../views/form_block.php'); ?>



<!-- IMPORT SITE FOOTER -->
<?php require_once('../views/footer.php'); ?>