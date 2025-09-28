<?php

    require_once('../includes/init.php');

    $quiz_page = './quiz.php';

    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : null; 

    require_once('../controllers/WordController.php'); // for Add/Edit Word form
    require_once('../controllers/FilterController.php'); // for Vocabulary Filter
    require_once('../controllers/AuthController.php');
    require_once('../includes/Validator.php');
    require_once('../includes/Database.php');
    $word = new WordController;
    $val = new Validator;
    $db = new Database;
    $filter = new FilterController;
    $auth = new AuthController; 

    switch ($action) {
        case 'addword':
            $word->add_word();
            break;
        case 'filter':
            $filter->filter($user_id);
            break;
        case 'deleteword':
            $word_id = $_REQUEST['wordid'];
            $word->delete_word($user_id, $word_id);
            break;
        case 'editword':
            $word_id = $_REQUEST['wordid'];
            $word->edit_word($user_id, $word_id);
            break;
        case 'startquiz':
            $lang = $_POST['language'];
            $cat = $_POST['category'];
            $word->get_word_set($user_id, $lang, $cat);
            break;
        case 'quiznextround':
            $word->next_round();
            break;
        case 'registerquiz':
            $word->register_quiz($user_id);
            break;
        case 'logout':
            $auth->logout();
            break;
        case 'login':
            $auth->login();
            break;
        case 'signup':
            $auth->signup();
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