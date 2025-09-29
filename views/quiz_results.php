
    <div class="max-w-4xl mx-auto pb-[100px] px-3">
        <form action="../public/index.php?action=registerquiz" method="POST">
        <div class="divide-y divide-green-600 border-l-2 border-t-2 border-r-2 border-b-2 border-[#458B41] bg-black text-green-300 font-mono entries">
            <?php foreach($_SESSION['quiz_set'] as $key => $round): ?>
                <div class="p-4 hover:bg-green-950/40 flex justify-between entry" data-word-id="<?= $round['id'] ?>">
                    <div>
                        <!-- WORD -->
                        <div class="flex gap-4 items-center mb-2">
                            <span class="font-bold text-[#458B41]">Word/Phrase:</span>
                            <span class="text-xl entry-word"><?= $round['word'] ?></span>
                        </div>
                        <!-- TRANSLATION -->
                        <div class="flex gap-4 items-center mb-2">
                            <span class="font-bold text-[#458B41]">Translation:</span>
                            <span><?= $round['translation'] ?></span>
                        </div>
                        <!-- ANSWER -->
                        <div class="flex gap-4 items-center">
                            <span class="font-bold text-[gold]">You Answered:</span>
                            <span><?= $_SESSION['quiz_answers'][$key] ?></span>
                        </div>
                        <!-- LANG & CAT -->
                        <div class="flex gap-6 mt-2 text-sm">
                            <span><span class="text-[#458B41]">Language:</span> <span class="entry-lang"><?= $languages[$round['language']] ?></span></span>
                            <span><span class="text-[#458B41]">Category:</span> <?= ucwords(str_replace('_', ' ', $round['category'])) ?></span>
                        </div>
                        <!-- EXAMPLE -->
                        <?php if ($round['example']): ?>
                            <div class="mt-2">
                                <span class="font-bold text-[#458B41]">Example:</span>
                                <p class="ml-2"><?= $round['example'] ?></p>
                            </div>
                        <?php endif; ?>
                        <!--  -->
                        <?php if ($round['notes']): ?>
                        <div class="mt-2">
                            <span class="font-bold text-[#458B41]">Notes:</span>
                            <p class="ml-2"><?= $round['notes'] ?></p>
                        </div>
                        <?php endif; ?>
                    </div>  
                    <div>
                        <span>Test your knowledge:</span>
                        <div class="flex flex-col gap-1 font-mono">
                            <!-- Weak -->
                            <label class="cursor-pointer w-full block">
                                <input type="radio" name="<?= $key ?>-strength" value="weak" class="hidden peer" />
                                <span class="px-3 py-1 bg-black border-2 border-red-500 text-red-400 uppercase peer-checked:bg-red-900 peer-checked:text-red-200 w-full inline-block">
                                Weak
                                </span>
                            </label>

                            <!-- Medium -->
                            <label class="cursor-pointer">
                                <input type="radio" name="<?= $key ?>-strength" value="medium" class="hidden peer" />
                                <span class="px-3 py-1 bg-black border-2 border-yellow-500 text-yellow-400 uppercase peer-checked:bg-yellow-900 peer-checked:text-yellow-200 w-full inline-block">
                                Medium
                                </span>
                            </label>

                            <!-- Strong -->
                            <label class="cursor-pointer">
                                <input type="radio" name="<?= $key ?>-strength" value="strong" class="hidden peer" />
                                <span class="px-3 py-1 bg-black border-2 border-green-500 text-green-400 uppercase peer-checked:bg-green-900 peer-checked:text-green-200 w-full inline-block">
                                Strong
                                </span>
                            </label>

                            <!-- Mastered -->
                            <label class="cursor-pointer">
                                <input type="radio" name="<?= $key ?>-strength" value="mastered" class="hidden peer" />
                                <span class="px-3 py-1 bg-black border-2 border-blue-500 text-blue-400 uppercase peer-checked:bg-blue-900 peer-checked:text-blue-200 w-full inline-block">
                                Mastered
                                </span>
                            </label>
                        </div>


                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <button class="inline-block mt-8 bg-black border-2 border-[#458B41] text-green-300 font-mono px-4 py-2 uppercase tracking-wider hover:bg-green-800 hover:text-green-200 active:opacity-70 btn-reg-results">Register results</button>
                        </form>
    </div>