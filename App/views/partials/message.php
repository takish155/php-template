<?php if (isset($_SESSION["success_message"])): ?>

  <div class="bg-green-500 text-white py-4 mb-4 p-4 text-lg ">
    <p>
      <?= $_SESSION["success_message"] ?>
    </p>
  </div>
  <?php unset($_SESSION["success_message"]); ?>
<?php endif; ?>


<?php if (isset($_SESSION["error_message"])): ?>

  <div class="bg-red-500 text-white py-4 mb-4 p-4 text-lg ">
    <p>
      <?= $_SESSION["error_message"] ?>
    </p>
  </div>
  <?php unset($_SESSION["error_message"]); ?>
<?php endif; ?>