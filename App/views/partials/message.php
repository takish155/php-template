<?php

use Framework\Session;

$successMessage = Session::getFlashMessage("success_message");
$errorMessage = Session::getFlashMessage("error_message");
?>



<?php if (isset($successMessage)): ?>

  <div class="bg-green-500 text-white py-4 mb-4 p-4 text-lg ">
    <p>
      <?= $successMessage ?>
    </p>
  </div>
<?php endif; ?>


<?php if (isset($errorMessage)): ?>

  <div class="bg-red-500 text-white py-4 mb-4 p-4 text-lg ">
    <p>
      <?= $errorMessage ?>
    </p>
  </div>
<?php endif; ?>