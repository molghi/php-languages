<div>
    <form action="../public/index.php?action=startquiz" method="POST">
    <div class="bg-black text-green-400 font-mono p-6 max-w-md mx-auto space-y-6 border-2 border-[#458B41] shadow-lg">
            <!-- Row 1: Select language -->
            <div>
                <label for="lang" class="block mb-1 uppercase text-green-300">Select Language</label>
                <select name="language" id="lang" class="w-full bg-black border border-[#458B41] text-green-400 p-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                <?php foreach($languages as $key=>$val): ?>
                        <option value="<?= $key ?>">
                            <?= $val ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Row 2: Select category -->
            <div>
                <label for="cat" class="block mb-1 uppercase text-green-300">Select Category</label>
                <select name="category" id="cat" class="w-full bg-black border border-[#458B41] text-green-400 p-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="all">All</option>
                <?php foreach($categories as $key=>$val): ?>
                        <option value="<?= $key ?>">
                            <?= $val ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Row 3: Button -->
            <div class="text-center">
                <button class="bg-black border-2 border-[#458B41] text-green-300 px-6 py-2 uppercase font-bold hover:bg-green-900 transition">
                Begin
                </button>
            </div>
        </div>
    </form>

    <!-- output errors/msgs -->
     <?php if (isset($_SESSION['quiz_msg'])): ?>
        <div class="max-w-md mx-auto bg-black border border-[coral] text-[coral] px-4 py-3 mt-6 font-mono" role="alert">
            <strong class="font-bold">Message: </strong>
            <span class="block sm:inline">
                You have not added any words in this language (<span class="opacity-60"><?= ucwords($_SESSION['quiz_msg'][0]) ?></span>) or category (<span class="opacity-60"><?= $_SESSION['quiz_msg'][1] === 'all' ? 'All' : $categories[$_SESSION['quiz_msg'][1]] ?></span>), <b><u>OR</u></b> their next review is not yet due.<br>> Add more words to practice now.
            </span>
            <?php unset($_SESSION['quiz_msg']); ?>
        </div>
     <?php endif; ?>
</div>
