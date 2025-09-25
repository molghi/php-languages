<?php

    require_once('../includes/init.php');

    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : null; 

    require_once('../controllers/FormController.php'); // for Add/Edit Word form
    require_once('../controllers/FilterController.php'); // for Vocabulary Filter
    require_once('../includes/Validator.php');
    require_once('../includes/Database.php');
    $form = new FormController;
    $val = new Validator;
    $db = new Database;
    $filter = new FilterController;

    $user_id = 1;

    switch ($action) {
        case 'addword':
            $form->add_word();
            break;
        case 'filter':
            $filter->filter($user_id);
            break;
        default:
            break;
    }

?>


<!-- IMPORT SITE HEADER -->
<?php require_once('../views/header.php'); ?>


<!-- IMPORT MAIN PAGE CONTENT -->
<?php require_once('../views/index_msg.php'); ?>



<!-- IMPORT SITE FOOTER -->
<?php require_once('../views/footer.php'); ?>