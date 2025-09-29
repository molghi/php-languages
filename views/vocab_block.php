<div class="max-w-6xl mx-auto pb-[100px] px-3">

    <h2 class="<?= $big_title_styles ?>">Your Vocabulary</h2>

    <?php if(isset($_SESSION['quiz_msg'])): ?>
    <div class="my-4 bg-black border border-blue-400 text-blue-400 px-4 py-3 font-mono">
        <?= $_SESSION['quiz_msg'] ?>
    </div>
    <?php unset($_SESSION['quiz_msg']); ?>
    <?php endif; ?>

    <!-- Filter row -->
    <div class="w-full bg-black text-[#458B41] font-mono border-b-2 border-[#458B41] py-3 flex items-center gap-4 mt-4 pb-8 flex-wrap lg:flex-nowrap">
        <form action="../public/index.php?action=filter" method="POST" class="flex items-center gap-4 flex-wrap lg:flex-nowrap">
            <div class="w-full sm:w-auto">
                <label for="lang" class="uppercase text-md inline-block mb-2 sm:mb-0">Language:</label>
                <select name="language" id="lang" class="bg-black text-[#458B41] border border-[#458B41] px-2 py-1 focus:outline-none w-full sm:w-auto">
                    <option value="all">All</option>
                    <?php foreach($added_languages_clean as $key => $val): ?>
                        <option value="<?= $val ?>"
                            <?= $is_filter_on && $lang === $val ? 'selected' : '' ?>
                        >
                            <?= $languages[$val] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="w-full sm:w-auto">
                <label for="cat" class="uppercase text-md lg:ml-4 inline-block mb-2 sm:mb-0">Category:</label>
                <select name="category" id="cat" class="bg-black text-[#458B41] border border-[#458B41] px-2 py-1 focus:outline-none w-full sm:w-auto">
                    <option value="all">All</option>
                    <?php foreach($added_categories_clean as $key => $val): ?>
                        <option value="<?= $val ?>"
                            <?= $is_filter_on && $cat === $val ? 'selected' : '' ?>
                        >
                            <?= ucwords(str_replace('_', ' ', $val)) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="lg:ml-5 bg-green-500 text-black px-3 py-1 font-bold uppercase tracking-wider hover:bg-[#458B41] active:opacity-70">
                Filter
            </button>
        </form>

        <div class="md:ml-auto">Entries: <?= $user_words && count($user_words) > 0 ? count($user_words) : 0 ?></div>
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
    <div class="divide-y divide-green-600 border-l-2 border-r-2 border-b-2 border-[#458B41] bg-black text-green-300 font-mono entries">
    <!-- Entries -->
        <?php if ($user_words && count($user_words) > 0): ?>
            <?php foreach($user_words as $entry): ?>
                <div class="p-4 hover:bg-green-950/40 flex justify-between entry flex-wrap xl:flex-nowrap gap-y-4 xl:gap-y-0" data-word-id="<?= $entry['id'] ?>">
                    <div>
                        <!-- WORD -->
                        <div class="flex gap-4 items-center mb-2 entry-word">
                            <span class="font-bold text-[#458B41]">Word/Phrase:</span> <span class="text-xl entry-word"><?= $entry['word'] ?></span>
                        </div>
                        <!-- TRANSLATION -->
                        <div class="flex gap-4 items-center entry-translation">
                            <span class="font-bold text-[#458B41]">Translation:</span>
                            <span><?= $entry['translation'] ?></span>
                        </div>
                        <!-- LANG & CAT -->
                        <div class="flex gap-x-10 gap-y-2 mt-2 text-sm flex-wrap lg:flex-nowrap">
                            <div class="min-w-[196px]">
                                <span class="text-[#458B41]">Language:</span> 
                                <span class="entry-lang"><?= $languages[$entry['language']] ?></span>
                            </div>

                            <div class="min-w-[279px]">
                                <span class="text-[#458B41]">Category:</span> 
                                <span><?= ucwords(str_replace('_', ' ', $entry['category'])) ?></span>
                            </div>

                            <div class="min-w-[152px]">
                                <span class="text-[#458B41]">Strength:</span> 
                                <?php
                                    if ($entry['strength'] === 0) $color = 'text-[white]';
                                    if ($entry['strength'] === 1) $color = 'text-red-400';
                                    if ($entry['strength'] === 2) $color = 'text-yellow-400';
                                    // if ($entry['strength'] === 3) $color = 'text-green-400';
                                    if ($entry['strength'] === 3) $color = 'text-[limegreen]';
                                    if ($entry['strength'] === 4) $color = 'text-blue-400';
                                ?>
                                <span class="<?= $color; ?>"
                                ><?= $strengths[$entry['strength']] ?></span>
                            </div>

                            <?php if($entry['next_revision']): ?>
                            <div class="whitespace-normal lg:whitespace-nowrap">
                                <span class="text-[#458B41]">Next Review:</span> 
                                <?php $nextRev = get_time_interval($entry['next_revision']); ?>
                                <span <?= $nextRev === 'Due' ? 'class="text-[coral]"' : '' ?>><?= $nextRev ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                        <!-- EXAMPLE -->
                        <?php if ($entry['example']): ?>
                            <div class="mt-2">
                                <span class="font-bold text-[#458B41]">Example:</span>
                                <p class="ml-2"><?= $entry['example'] ?></p>
                            </div>
                        <?php endif; ?>
                        <!--  -->
                        <?php if ($entry['notes']): ?>
                        <div class="mt-2">
                            <span class="font-bold text-[#458B41]">Notes:</span>
                            <p class="ml-2"><?= $entry['notes'] ?></p>
                        </div>
                        <?php endif; ?>
                    </div>  
                    <div>
                        <!-- Action buttons -->
                        <div class="flex gap-4">
                        <button class="flex items-center gap-1 bg-black border border-green-400 text-green-400 px-2 py-1 text-sm uppercase opacity-30 hover:opacity-100 active:opacity-70 edit-entry">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="flex items-center gap-1 bg-black border border-red-500 text-red-500 px-2 py-1 text-sm uppercase opacity-30 hover:opacity-100 active:opacity-70 delete-entry">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="italic p-4">Nothing to show...</div>
        <?php endif; ?>

    </div>

</div>