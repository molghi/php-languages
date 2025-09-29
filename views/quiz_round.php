<div class="bg-black text-green-400 font-mono max-w-xl mx-auto p-6 border-2 border-green-400 shadow-lg space-y-8">
  
  <!-- Progress bar -->
  <div class="w-full bg-green-900 border border-green-400 h-6 relative">
    <div class="bg-[limegreen] h-full" style="width: <?= ((int) $quiz_round / count($quiz_set))*100 . '%' ?>;"></div>
    <span class="absolute inset-0 flex items-center justify-center text-black font-bold text-sm">
      Round <?= $quiz_round; ?> / <?= count($quiz_set); ?>
    </span>
  </div>
  
  <!-- Round title -->
  <h2 class="text-2xl text-[#458B41] tracking-widest">Translate this: 
    <span class="text-green-300"><?= $quiz_set[$quiz_round-1]['word'] ?></span>
  </h2>

  <h3 class="text-lg text-[#458B41] tracking-widest">Category: <span class="text-green-500"><?= ucwords(str_replace('_', ' ', $quiz_set[$quiz_round-1]['category'])); ?></span></h3>

  <?php if ($quiz_set[$quiz_round-1]['example']): ?>
    <h3 class="text-lg text-[#458B41] tracking-widest">Example: <span class="text-green-500"><?= $quiz_set[$quiz_round-1]['example']; ?></span></h3>
  <?php endif; ?>

  <?php if ($quiz_set[$quiz_round-1]['notes']): ?>
    <h3 class="text-lg text-[#458B41] tracking-widest">Notes: <span class="text-green-500"><?= $quiz_set[$quiz_round-1]['notes']; ?></span></h3>
  <?php endif; ?>
  
  <!-- Quiz form -->
  <form action="../public/index.php?action=quiznextround" method="POST" class="space-y-10 pb-4">
    <input autofocus="true" type="text" placeholder="Enter your answer..." name="answer"
      class="w-full bg-black border border-green-400 text-green-300 p-2 focus:outline-none focus:ring-2 focus:ring-green-500"
    />

    <button type="submit" class="w-full bg-black border-2 border-green-400 text-green-300 font-bold py-2 uppercase hover:bg-green-900 transition">
        <?= $quiz_round === count($quiz_set) ? 'Finish' : 'Submit' ?>
    </button>
  </form>
</div>

