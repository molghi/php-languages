<?php

    require_once('../includes/init.php');

    $page = 'quiz';

    // passing things to header.php
    $doc_title = 'PHP Vocab Trainer: Quiz'; 

    if (isset($_SESSION['quiz_set'])) {
        $quiz_set = $_SESSION['quiz_set'];
        $quiz_round = $_SESSION['quiz_round'];
    } 

    if (!isset($_REQUEST['lang']) && (!isset($_REQUEST['action']) )) {
        // && $_REQUEST['action'] !== 'quizdone'
        unset($_SESSION['quiz_set']);
        unset($_SESSION['quiz_params']);
        unset($_SESSION['quiz_round']);
        unset($_SESSION['quiz_answers']);
    }

    require_once('../includes/Database.php');
    $db = new Database;

    $added_categories = $db->get_added_categories($user_id);
    $added_categories_clean = [];
    foreach($added_categories as $i) {  array_push($added_categories_clean, $i['category']);  }
    sort($added_categories_clean);

    $added_languages = $db->get_added_languages($user_id);
    $added_languages_clean = [];
    foreach($added_languages as $i) {  array_push($added_languages_clean, $i['language']);  }
?>


<!-- IMPORT SITE HEADER -->
<?php require_once('../views/header.php'); ?>



<!-- IMPORT MAIN PAGE CONTENT -->
<h2 class="<?= $big_title_styles ?>">
    Quiz
    <!-- output lang flag: -->
    <?= isset($_SESSION['quiz_set']) && isset($_REQUEST['lang']) ? explode(' ', $languages[$_REQUEST['lang']])[0] : '' ?>
    <?= isset($_REQUEST['action']) && $_REQUEST['action'] === 'quizdone' ? ' Results' : '' ?>
</h2>

<?php if(isset($_REQUEST['action']) && $_REQUEST['action'] === 'quizdone'): ?>
    <?php require_once('../views/quiz_results.php'); ?>
<?php elseif (isset($_SESSION['quiz_set'])): ?>
    <?php require_once('../views/quiz_round.php'); ?>
<?php else: ?>
    <?php require_once('../views/quiz_start.php'); ?>
<?php endif; ?>




<!-- IMPORT SITE FOOTER -->
<?php require_once('../views/footer.php'); ?>