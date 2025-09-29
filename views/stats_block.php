<h2 class="<?= $big_title_styles ?> mb-[50px]">Statistics for 
    <span class="font-semibold text-blue-400" title="<?= htmlspecialchars($profile_info['email']); ?>"><?= htmlspecialchars($profile_info['username']); ?></span>
</h2>




<div class="grid grid-cols-1 sm:grid-cols-2 gap-x-10 gap-y-5 max-w-3xl mx-auto bg-black border-2 border-[#458B41] p-8 font-mono text-green-300 <?= !$lang_stats ? 'mb-[100px]' : '' ?>">
  
    <div class="flex justify-between border-b border-[#458B41] pb-1 gap-x-4">
      <span class="text-green-400 uppercase text-md">Total Words Added</span>
      <span class="font-semibold text-green-100"><?= $added_words ?></span>
    </div>

    <div class="flex justify-between border-b border-[#458B41] pb-1 gap-x-4">
      <span class="text-green-400 uppercase text-md">Next Review</span>
      <span class="font-semibold <?= $next_review_in === 'Due' ? 'text-[coral]' : '' ?><?= $next_review_in === 'Now' ? 'text-[limegreen]' : 'text-green-100' ?>"><?= $next_review_in ?></span>
    </div>

    <div class="flex justify-between border-b border-[#458B41] pb-1 gap-x-4" title="<?= $words_count_to_review ? 'In ' . $words_count_to_review_langs : "" ?>">
      <span class="uppercase text-md <?= $words_count_to_review ? 'text-green-700' : 'text-green-400' ?>">Words to Review Now</span>
      <span class="font-semibold text-green-100"><?= $words_count_to_review ? $words_count_to_review_num : '0' ?></span>
    </div>

    <div class="flex justify-between border-b border-[#458B41] pb-1 gap-x-4" title="<?= ucwords($langs_added) ?>">
      <span class="text-green-700 uppercase text-md">Languages Added</span>
      <span class="font-semibold text-green-100"><?= count($lang_count) ?></span>
    </div>

    <div class="flex justify-between border-b border-[#458B41] pb-1 gap-x-4" title="Words that are untested, weak or medium (across all added languages)">
      <span class="text-green-700 uppercase text-md">Words in rotation</span>
      <span class="font-semibold text-green-100"><?= $words_in_rotation ?></span>
    </div>

    <div class="flex justify-between border-b border-[#458B41] pb-1 gap-x-4" title="Words that are strong or mastered (across all added languages)">
      <span class="text-green-700 uppercase text-md">Words Learned</span>
      <span class="font-semibold text-green-100"><?= $words_learned ?></span>
    </div>

    <div class="flex justify-between border-b border-[#458B41] pb-1 gap-x-4">
      <span class="text-green-400 uppercase text-md">Sessions Played Today</span>
      <span class="font-semibold text-green-100"><?= $sessions_played_today ?></span>
    </div>

    <div class="flex justify-between border-b border-[#458B41] pb-1 gap-x-4">
      <span class="text-green-400 uppercase text-md">Previously Played</span>
      <span class="font-semibold text-green-100"><?= !$prev_played_day ? 'Never' : get_time_interval($prev_played_day['played_at'], 'last_played') . ' ago' ?></span>
    </div>

</div>




<?php if ($lang_stats && count($lang_stats) > 0): ?>
<div class="mt-[50px] mb-[100px] max-w-3xl mx-auto font-mono">
<h3 class="capitalize text-2xl font-mono text-green-600 mb-8 inline-block pb-1 border-b border-b-green-600 mx-2 md:mx-0">Strength distribution per language</h3>
<?php foreach($lang_stats as $lang): ?>
    <div class="mb-[40px] px-2 md:px-0">
        <div class="flex gap-x-7 gap-y-2 border-b border-[#458B41] pb-1 text-[13px] sm:text-[16px] flex-wrap sm:flex-nowrap">
            <span class="text-green-400 text-md">Language:</span>
            <span class="font-semibold text-green-100"><?= $languages[$lang['language']] ?></span>
            <span class="sm:ml-auto text-gray-500">Total words: <?= $lang['total_words'] ?></span>
        </div>
        <!-- Bar -->
        <div class="flex mt-5 border border-[gray] text-[13px] sm:text-[16px]">
            <?php if ($lang['untested'] > 0): ?>
                <div class="h-[25px] bg-[#A9A9A9] relative"    style="width: <?= floor(((int) $lang['untested'] / (int) $lang['total_words'])*100) ?>%;" title="<?= $lang['untested'] ?> words with strength 'untested'">
                    <span class="text-[black] font-mono absolute inset-0 left-[10px] top-[1px]">Untested (<?= $lang['untested'] ?>)</span>
                </div>
            <?php endif; ?>
            
            <?php if ($lang['weak'] > 0): ?>
                <div class="h-[25px] bg-red-900 relative"    style="width: <?= floor(((int) $lang['weak'] / (int) $lang['total_words'])*100) ?>%;" title="<?= $lang['weak'] ?> words with strength 'weak'">
                    <span class="text-[white] font-mono absolute inset-0 left-[10px] top-[1px]">Weak (<?= $lang['weak'] ?>)</span>
                </div>
            <?php endif; ?>
            
            <?php if ($lang['medium'] > 0): ?>
                <div class="h-[25px] bg-yellow-700 relative" style="width: <?= floor(((int) $lang['medium'] / (int) $lang['total_words'])*100) ?>%;" title="<?= $lang['medium'] ?> words with strength 'medium'">
                    <span class="text-[white] font-mono absolute inset-0 left-[10px] top-[1px]">Medium (<?= $lang['medium'] ?>)</span>
                </div>
            <?php endif; ?>
            
            <?php if ($lang['strong'] > 0): ?>
                <div class="h-[25px] bg-green-800 relative"  style="width: <?= floor(((int) $lang['strong'] / (int) $lang['total_words'])*100) ?>%;" title="<?= $lang['strong'] ?> words with strength 'strong'">
                    <span class="text-[white] font-mono absolute inset-0 left-[10px] top-[1px]">Strong (<?= $lang['strong'] ?>)</span>
                </div>
            <?php endif; ?>
            
            <?php if ($lang['mastered'] > 0): ?>
                <div class="h-[25px] bg-blue-900 relative"   style="width: <?= floor(((int) $lang['mastered'] / (int) $lang['total_words'])*100) ?>%;" title="<?= $lang['mastered'] ?> words with strength 'mastered'">
                    <span class="text-[white] font-mono absolute inset-0 left-[10px] top-[1px]">Mastered (<?= $lang['mastered'] ?>)</span>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>
<div class="text-green-600 mt-14">
    <span class="font-bold text-green-800">Categories Added:</span> 
    (<?= count($added_categories_clean) ?>) <?= $added_categories_joined ?>.
</div>
</div>
<?php endif; ?>




