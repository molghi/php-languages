<?php

    require_once('../includes/init.php');

    $mode = 'add';

    $form_data = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : null;

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