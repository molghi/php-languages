<!-- output msgs -->
    <?php if (isset($_SESSION['form_msg'])): ?>
        <div class="max-w-xl mx-auto bg-black border border-[gold] text-[gold] px-4 py-3 mt-6 font-mono mt-6 mb-[-15px]" role="alert">
            <strong class="font-bold">Message: </strong>
            <span class="block sm:inline"><?php echo $_SESSION['form_msg']; ?></span>
        </div>
    <?php unset($_SESSION['form_msg']); ?>
    <?php endif; ?>




<div class="max-w-xl mx-auto mt-10 p-6 bg-black border-2 border-[#458B41] shadow-lg font-mono text-[#458B41] relative mb-10">
  <h2 class="text-2xl font-bold mb-6 uppercase"><?= $mode === 'add' ? 'Add New ' : 'Edit '; ?> Word</h2>
  
  <form method="POST" action="<?= $mode === 'add' ? '../public/index.php?action=addword' : '../public/index.php?action=editword&wordid=' . $word_to_edit['id'] ?>" class="space-y-4">
    <!-- Word / Phrase -->
    <div>
      <label class="block mb-1">Word / Phrase <span class="text-red-500">*</span></label>
      <input autofocus="true" autocomplete="off" name="word" type="text" placeholder="Enter word" class="w-full px-3 py-2 bg-black border border-[#458B41] rounded focus:outline-none focus:ring-2 focus:ring-green-500"
        value="<?= $mode === 'add' && $form_data ? htmlspecialchars($form_data['word']) : '' ?><?= $mode === 'edit' ? htmlspecialchars($word_to_edit['word']) : '' ?>"
      />
    </div>

    <!-- Translation -->
    <div>
      <label class="block mb-1">Translation <span class="text-red-500">*</span></label>
      <input type="text" name="translation" autocomplete="off" placeholder="Enter translation" class="w-full px-3 py-2 bg-black border border-[#458B41] rounded focus:outline-none focus:ring-2 focus:ring-green-500"
        value="<?= $mode === 'add' && $form_data ? htmlspecialchars($form_data['translation']) : '' ?><?= $mode === 'edit' ? htmlspecialchars($word_to_edit['translation']) : '' ?>"
      />
    </div>

    <!-- Language -->
     <div class="flex gap-4 flex-col sm:flex-row">
        <div class="flex-1">
            <label class="block mb-1">Language <span class="text-red-500">*</span></label>
            <select name="language" class="w-full min-h-[42px] px-3 py-2 bg-black border border-[#458B41] rounded focus:outline-none focus:ring-2 focus:ring-green-500">
                <?php foreach($languages as $key=>$val): ?>
                    <option value="<?= $key ?>" 
                        <?= $mode === 'add' && $form_data && $form_data['language'] === $key ? 'selected' : '' ?>
                        <?= isset($_SESSION['last_entered_lang']) && $_SESSION['last_entered_lang'] === $key ? 'selected' : '' ?>
                        <?= $mode === 'edit' && $word_to_edit['language'] === $key ? 'selected' : '' ?>
                    >
                        <?= $val ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Category -->
        <div class="flex-1 relative category-block">
            <label class="block mb-1">Category <span class="text-red-500">*</span></label>
            <input type="text" name="category" placeholder="Enter category" class="w-full px-3 py-2 bg-black border border-[#458B41] rounded focus:outline-none focus:ring-2 focus:ring-green-500"
                <?= $mode === 'edit' ? 'value="' . $word_to_edit['category'] . '"' : '' ?>
            />
        </div>
    </div>

    <!-- Example Sentence -->
    <div>
      <label class="block mb-1">Example Sentence</label>
      <textarea autocomplete="off" name="example" placeholder="Optional sentence" class="w-full min-h-[42px] h-[42px] max-h-[100px] px-3 py-2 bg-black border border-[#458B41] rounded focus:outline-none focus:ring-2 focus:ring-green-500"><?= $mode === 'add' && $form_data ? htmlspecialchars($form_data['example']) : '' ?><?= $mode === 'edit' ? htmlspecialchars($word_to_edit['example']) : '' ?></textarea>
    </div>

    <!-- Notes / Hint -->
    <div>
      <label class="block mb-1">Notes / Hint</label>
      <!-- <input name="notes" type="text" placeholder="Optional hint" class="w-full px-3 py-2 bg-black border border-[#458B41] rounded focus:outline-none focus:ring-2 focus:ring-green-500"/> -->
      <textarea name="notes" placeholder="Optional hint" autocomplete="off" class="w-full min-h-[42px] h-[42px] max-h-[100px] px-3 py-2 bg-black border border-[#458B41] rounded focus:outline-none focus:ring-2 focus:ring-green-500"><?= $mode === 'add' && $form_data ? htmlspecialchars($form_data['notes']) : '' ?><?= $mode === 'edit' ? htmlspecialchars($word_to_edit['notes']) : '' ?></textarea>
    </div>

    <!-- Tags -->
    <!-- <div>
      <label class="block mb-1">Tags</label>
      <input type="text" placeholder="Comma-separated tags" class="w-full px-3 py-2 bg-black border border-[#458B41] rounded focus:outline-none focus:ring-2 focus:ring-green-500"/>
    </div> -->

    <!-- Submit Button -->
    <div class="pt-4">
      <button type="submit" class="w-full py-2 bg-[#458B41] text-black font-bold rounded hover:bg-green-500 shadow-lg uppercase tracking-wider">
        <?= $mode === 'add' ? 'Add' : 'Edit'; ?> Word
      </button>
    </div>
  </form>

  <!-- OUTPUT ERRORS -->
    <?php if (isset($_SESSION['form_error'])): ?>
        <div class="bg-black border border-red-700 text-red-700 px-4 py-3 rounded-md mt-6" role="alert">
            <strong class="font-bold">Error: </strong>
            <span class="block sm:inline"><?php echo $_SESSION['form_error']; ?></span>
        </div>
    <?php unset($_SESSION['form_error']); ?>
    <?php endif; ?>
</div>

