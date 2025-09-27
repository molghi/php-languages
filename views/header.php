<?php

    require_once('../includes/init.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo isset($doc_title) ? $doc_title : 'PHP Vocab Trainer'; ?>
    </title>

    <!-- IMPORT TAILWIND -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- IMPORT FONTAWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- CUSTOM STYLES -->
    <?php require_once('../views/custom_styles.php'); ?>
</head>

<body style="background-color: black;" class="flex flex-col min-h-screen relative">
    
    <main class="flex-1 relative z-10">

    
     <!-- HEADER BLOCK -->
     <?php require_once('../views/header_block.php'); ?>