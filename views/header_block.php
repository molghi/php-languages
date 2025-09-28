<header class="relative overflow-hidden w-full bg-black border-b-2 border-[#458B41] text-[#458B41] font-mono tracking-widest shadow-lg">
         <!-- <header class="relative overflow-hidden w-full bg-black border-b-4 border-green-500 text-green-400 font-mono tracking-widest shadow-lg "> -->
        <div class="max-w-6xl mx-auto px-4 py-6 flex items-center justify-between">

            <!-- Logo / Title -->
            <h1 class="text-2xl md:text-3xl font-bold uppercase animate-pulse">
                <a href="../public/index.php">VOCAB-TRAINER-6525</a>
            </h1>
            
            <!-- Navigation -->
            <?php if ($user_id):?>
            <nav class="flex space-x-8 text-lg">
                <a href="../public/form.php" class="hover:text-green-200 hover:underline underline-offset-4 <?= $page === 'form' ? 'underline' : '' ?>">
                    <?= isset($mode) && $mode === 'edit' ? 'Edit Word' : 'Add Word' ?>
                </a>
                <a href="../public/vocabulary.php" class="hover:text-green-200 hover:underline underline-offset-4 <?= $page === 'vocabulary' ? 'underline' : '' ?>">
                    Vocabulary
                </a>
                <a href="../public/quiz.php" class="hover:text-green-200 hover:underline underline-offset-4 <?= $page === 'quiz' ? 'underline' : '' ?>">
                    Quiz
                </a>
                <a href="../public/stats.php" class="hover:text-green-200 hover:underline underline-offset-4 <?= $page === 'stats' ? 'underline' : '' ?>">
                    Stats
                </a>
                <button class="hover:text-green-200 hover:underline underline-offset-4 btn-log-out active:opacity-60">
                    Log Out
                </button>
            </nav>
            <?php else: ?>
                <a href="../public/auth.php" class="hover:text-green-200 hover:underline underline-offset-4 <?= $page === 'auth' ? 'underline' : '' ?>">
                    Sign Up or Log In
                </a>
            <?php endif; ?>
        </div>

         <!-- Moving scanline overlay -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="w-full h-full scanlines"></div>
        </div>
</header>