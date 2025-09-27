<?php

    require_once('../includes/init.php');

    $page = 'stats';

    // passing things to header.php
    $doc_title = 'PHP Vocab Trainer: Stats';
?>


<!-- IMPORT SITE HEADER -->
<?php require_once('../views/header.php'); ?>



<!-- IMPORT MAIN PAGE CONTENT -->
<div class="font-mono text-green-600 container mx-auto my-10 px-20">
    PAGE CONCEPT<br><br>
    A stats page is optional but useful for user motivation and progress tracking. Typical elements:<br><br>
<ul class="list-disc pl-5">
    <li>Overview numbers: total words added, words learned, words due for review.</li>
    <li>Accuracy: % correct in quizzes, streaks, success rate per language/category.</li>
    <li>Strength distribution: how many words are Weak / Medium / Strong / Mastered.</li>
    <li>Upcoming reviews: next due words or scheduled revision dates.</li>
    <li>Trends over time: graph of learned words vs. time, quiz performance.</li>
    <li>Category breakdown: which topics are strongest/weakest.</li>
</ul><br>
Even a simple stats page (counts + strengths + next reviews) gives users actionable insight.
</div>



<!-- IMPORT SITE FOOTER -->
<?php require_once('../views/footer.php'); ?>