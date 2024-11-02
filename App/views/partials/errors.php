<?php if (isset($errors)) : ?>
  <div class="mb-6">
    <?php foreach ($errors as $err): ?>
      <div class="mb-2 bg-red-500 text-white rounded-lg text-sm py-2 px-4"><?= $err ?></div>
    <?php endforeach ?>
  </div>
<?php endif ?>