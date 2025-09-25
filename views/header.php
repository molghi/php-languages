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
    <style>
        /* shut up red local non-https warning */
        div[style="background: red; color: white; padding: 10px; position: fixed; bottom: 0px; width: 100%; text-align: center; z-index: 1000;"] {
            display: none !important;
        }
        /* Scanline overlay */
            .scanlines {
            background: repeating-linear-gradient(
                to bottom,
                rgba(0, 255, 0, 0.1) 0px,
                rgba(0, 255, 0, 0.1) 4px,
                transparent 4px,
                transparent 8px
            );
            background-size: 100% 16px; /* ensures visible vertical repetition */
            animation: scan 0.5s linear infinite; /* fast movement */
            }

            @keyframes scan {
            0% { background-position: 0 0; }
            100% { background-position: 0 16px; } /* move one full pattern height */
            }
    </style>
</head>

<body style="background-color: black;" class="flex flex-col min-h-screen relative">
    
    <main class="flex-1 relative z-10">

    
     <!-- HEADER BLOCK -->
     <header class="relative overflow-hidden w-full bg-black border-b-2 border-[#458B41] text-[#458B41] font-mono tracking-widest shadow-lg">
         <!-- <header class="relative overflow-hidden w-full bg-black border-b-4 border-green-500 text-green-400 font-mono tracking-widest shadow-lg "> -->
        <div class="max-w-6xl mx-auto px-4 py-6 flex items-center justify-between">
            <!-- Logo / Title -->
            <h1 class="text-2xl md:text-3xl font-bold uppercase animate-pulse">
                <a href="../public/index.php">VOCAB-TRAINER 6525</a>
            </h1>
            
            <!-- Navigation -->
            <nav class="flex space-x-6 text-lg">
            <a href="../public/form.php" class="hover:text-green-200 hover:underline underline-offset-4 <?= $page === 'form' ? 'underline' : '' ?>">Add Word</a>
            <a href="../public/vocabulary.php" class="hover:text-green-200 hover:underline underline-offset-4 <?= $page === 'vocabulary' ? 'underline' : '' ?>">Vocabulary</a>
            <!-- <a href="#" class="hover:text-green-200 hover:underline underline-offset-4">Dashboard</a> -->
            <!-- <a href="#" class="hover:text-green-200 hover:underline underline-offset-4">Quiz</a> -->
            <!-- <a href="#" class="hover:text-green-200 hover:underline underline-offset-4">Stats</a> -->
            </nav>
        </div>

         <!-- Moving scanline overlay -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="w-full h-full scanlines"></div>
        </div>
    </header>