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

    <!-- output error -->
     <?php if (isset($_REQUEST['error']) && $_REQUEST['error'] === 'nowords'): ?>
        <div class="max-w-md mx-auto bg-black border border-red-700 text-red-700 px-4 py-3 mt-6 font-mono" role="alert">
            <strong class="font-bold">Error: </strong>
            <span class="block sm:inline">You have not added any words in this language or category.</span>
        </div>
     <?php endif; ?>
</div>
