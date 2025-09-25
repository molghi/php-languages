<div class="max-w-6xl mx-auto pb-[100px]">

    <!-- Filter row -->
    <div class="w-full bg-black text-[#458B41] font-mono border-b-2 border-[#458B41] p-3 flex items-center gap-4 mt-4 pb-8">
        <form action="../public/index.php?action=filter" method="POST" class="flex items-center gap-4">
            <label for="lang" class="uppercase text-md">Language:</label>
            <select name="language" id="lang" class="bg-black text-[#458B41] border border-[#458B41] px-2 py-1 focus:outline-none">
                <option value="all">All</option>
                <?php foreach($languages as $key => $val): ?>
                    <option value="<?= $key ?>"
                        <?= $is_filter_on && $lang === $key ? 'selected' : '' ?>
                    >
                        <?= $val ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="cat" class="uppercase text-md ml-4">Category:</label>
            <select name="category" id="cat" class="bg-black text-[#458B41] border border-[#458B41] px-2 py-1 focus:outline-none">
                <option value="all">All</option>
                <?php foreach($categories as $key => $val): ?>
                    <option value="<?= $key ?>"
                        <?= $is_filter_on && $cat === $key ? 'selected' : '' ?>
                    >
                        <?= $val ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="ml-5 bg-green-500 text-black px-3 py-1 font-bold uppercase tracking-wider hover:bg-[#458B41] active:opacity-70">
                Filter
            </button>
        </form>

        <div class="ml-auto">Entries: <?= $user_words && count($user_words) > 0 ? count($user_words) : 0 ?></div>
    </div>




    <!-- OUTPUT ERRORS -->
        <div class="mb-5">
            <?php if (isset($_SESSION['filter_error'])): ?>
                <div class="bg-black border border-red-700 text-red-700 px-4 py-3 rounded-md mt-6" role="alert">
                    <strong class="font-bold">Error: </strong>
                    <span class="block sm:inline"><?php echo $_SESSION['filter_error']; ?></span>
                </div>
            <?php unset($_SESSION['filter_error']); ?>
        </div>
        <?php endif; ?>





    <!-- Word entries list -->
    <div class="divide-y divide-green-600 border-l-2 border-r-2 border-b-2 border-[#458B41] bg-black text-green-300 font-mono">
    <!-- Entries -->
        <?php if ($user_words && count($user_words) > 0): ?>
            <?php foreach($user_words as $entry): ?>
                <div class="p-4 hover:bg-green-950/40 flex justify-between" data-word-id="<?= $entry['id'] ?>">
                    <div>
                        <!-- WORD -->
                        <div class="flex gap-4 items-center mb-2">
                            <span class="font-bold text-[#458B41]">Word/Phrase:</span>
                            <span class="text-xl"><?= $entry['word'] ?></span>
                        </div>
                        <!-- TRANSLATION -->
                        <div class="flex gap-4 items-center">
                            <span class="font-bold text-[#458B41]">Translation:</span>
                            <span><?= $entry['translation'] ?></span>
                        </div>
                        <!-- LANG & CAT -->
                        <div class="flex gap-6 mt-2 text-sm">
                            <span><span class="text-[#458B41]">Language:</span> <?= $languages[$entry['language']] ?></span>
                            <span><span class="text-[#458B41]">Category:</span> <?= $categories[$entry['category']] ?></span>
                        </div>
                        <!-- EXAMPLE -->
                        <?php if ($entry['example']): ?>
                            <div class="mt-2">
                                <span class="font-bold text-[#458B41]">Example:</span>
                                <p class="ml-2">Bonjour, comment ça va ?</p>
                            </div>
                        <?php endif; ?>
                        <!--  -->
                        <?php if ($entry['notes']): ?>
                        <div class="mt-2">
                            <span class="font-bold text-[#458B41]">Notes:</span>
                            <p class="ml-2">Common greeting.</p>
                        </div>
                        <?php endif; ?>
                    </div>  
                    <div>
                        <!-- Action buttons -->
                        <div class="flex gap-4">
                        <button class="flex items-center gap-1 bg-black border border-green-400 text-green-400 px-2 py-1 text-sm uppercase opacity-50 hover:opacity-100 active:opacity-70">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="flex items-center gap-1 bg-black border border-red-500 text-red-500 px-2 py-1 text-sm uppercase opacity-50 hover:opacity-100 active:opacity-70">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="italic p-4">No words to show...</div>
        <?php endif; ?>

    </div>

</div>