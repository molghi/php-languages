<?php

    require_once('../includes/init.php');

    $page = 'auth';

    // passing things to header.php
    $doc_title = 'PHP Vocab Trainer: Auth';

?>


<!-- IMPORT SITE HEADER -->
<?php require_once('../views/header.php'); ?>



<!-- IMPORT MAIN PAGE CONTENT -->
<?php require_once('../views/auth_block.php'); ?>




<!-- IMPORT SITE FOOTER -->
<?php require_once('../views/footer.php'); ?>