<?php

    require_once('../includes/init.php');

    $page = 'stats';

    // passing things to header.php
    $doc_title = 'PHP Vocab Trainer: Stats';

    require_once('../includes/Database.php');
    $db = new Database;
    // fetch user's username & email
    $profile_info = $db->get_profile($user_id);

    // fetch num of added words
    $added_words = $db->get_words_count($user_id);

    // fetch soonest review
    $next_review = $db->get_next_review($user_id);
    if ($next_review) $next_review_in = get_time_interval($next_review, 'next_review');
    elseif ($next_review === null) $next_review_in = 'Now'; // if it's null, then some word was added and never tested
    elseif ($next_review === false) $next_review_in = '_'; // if it's false, then db returned no rows

    // fetch num of words to review now
    $words_count_to_review = $db->get_words_count_to_review($user_id);
    $words_count_to_review_num = 0;
    $words_count_to_review_langs = '';
    foreach($words_count_to_review as $i) { 
        $words_count_to_review_num += (int) $i['words_to_review']; 
        $words_count_to_review_langs .= ucwords($i['lang']) . ', ';
    }
    $words_count_to_review_langs = rtrim($words_count_to_review_langs, ', ');

    // fetch num of langs added
    $lang_count = $db->get_added_langs($user_id);
    $langs_added = [];
    foreach($lang_count as $i) {
        array_push($langs_added, $i['language']);
    }
    $langs_added = implode(", ", $langs_added);

    // fetch num of words of certain strengths
    $words_in_rotation = $db->get_words_in_rotation($user_id);
    $words_learned = $db->get_words_learned($user_id);

    // fetch how many times played today
    $sessions_played_today = $db->get_sessions_played_today($user_id);

    // fetch when played last time
    $prev_played_day = $db->get_prev_played_day($user_id);

    // fetch for each lang: total words in this lang, num of words of each strength
    $lang_stats = $db->get_lang_stats($user_id);

    // get all categories that a user has added
    $added_categories = $db->get_added_categories($user_id);
    $added_categories_clean = [];
    foreach($added_categories as $i) {  array_push($added_categories_clean, ucwords(str_replace('_', ' ', $i['category'])));  }
    sort($added_categories_clean);
    $added_categories_joined = implode(', ', $added_categories_clean);
?>


<!-- IMPORT SITE HEADER -->
<?php require_once('../views/header.php'); ?>



<!-- IMPORT MAIN PAGE CONTENT -->
<?php require_once('../views/stats_block.php'); ?>



<!-- IMPORT SITE FOOTER -->
<?php require_once('../views/footer.php'); ?>
