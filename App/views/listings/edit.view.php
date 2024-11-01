<?= loadPartials("head") ?>
<?= loadPartials("nav-bar") ?>
<?= loadPartials("top-banner") ?>

<section class="flex justify-center items-center mt-20">
  <div class="bg-white p-8 rounded-lg shadow-md w-full md:w-600 mx-6">
    <h2 class="text-4xl text-center font-bold mb-4">Edit Job info</h2>
    <?php loadPartials("message") ?>
    <form method="POST" action="/listings/<?= $info->id ?>">
      <input type="hidden" name="_method" value="PUT" />
      <h2 class="text-2xl font-bold text-center text-gray-500 mb-4">
        Job Info
      </h2>
      <?php if (isset($errors)) : ?>
        <div class="mb-6">
          <?php foreach ($errors as $err): ?>
            <div class="mb-2 bg-red-500 text-white rounded-lg text-sm py-2 px-4"><?= $err ?></div>
          <?php endforeach ?>
        </div>
      <?php endif ?>
      <div class="mb-4">
        <input
          value="<?= $info->title ?? "" ?>"
          type="text"
          name="title"
          placeholder="Job Title"
          class="w-full px-4 py-2 border rounded focus:outline-none" />
      </div>
      <div class="mb-4">
        <textarea
          name="description"
          placeholder="Job Description"
          class="w-full px-4 py-2 border rounded focus:outline-none">
          <?= $info->description ?? "" ?>
        </textarea>
      </div>
      <div class="mb-4">
        <input
          value="<?= $info->salary ?? "" ?>"
          type="text"
          name="salary"
          placeholder="Annual Salary"
          class="w-full px-4 py-2 border rounded focus:outline-none" />
      </div>
      <div class="mb-4">
        <input
          value="<?= $info->requirements ?? "" ?>"
          type="text"
          name="requirements"
          placeholder="Requirements"
          class="w-full px-4 py-2 border rounded focus:outline-none" />
      </div>
      <div class="mb-4">
        <input
          value="<?= $info->benefits ?? "" ?>"
          type="text"
          name="benefits"
          placeholder="Benefits"
          class="w-full px-4 py-2 border rounded focus:outline-none" />
      </div>
      <div class="mb-4">
        <input
          value="<?= $info->tags ?? "" ?>"
          type="text"
          name="tags"
          placeholder="Tags"
          class="w-full px-4 py-2 border rounded focus:outline-none" />
      </div>
      <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
        Company Info & Location
      </h2>
      <div class="mb-4">
        <input
          value="<?= $info->company ?? "" ?>"
          type="text"
          name="company"
          placeholder="Company Name"
          class="w-full px-4 py-2 border rounded focus:outline-none" />
      </div>
      <div class="mb-4">
        <input
          value="<?= $info->address ?? "" ?>"
          type="text"
          name="address"
          placeholder="Address"
          class="w-full px-4 py-2 border rounded focus:outline-none" />
      </div>
      <div class="mb-4">
        <input
          value="<?= $info->city ?? "" ?>"
          type="text"
          name="city"
          placeholder="City"
          class="w-full px-4 py-2 border rounded focus:outline-none" />
      </div>
      <div class="mb-4">
        <input
          value="<?= $info->prefecture ?? "" ?>"
          type="text"
          name="prefecture"
          placeholder="Prefecture"
          class="w-full px-4 py-2 border rounded focus:outline-none" />
      </div>
      <div class="mb-4">
        <input
          value="<?= $info->phone ?? "" ?>"
          type="text"
          name="phone"
          placeholder="Phone"
          class="w-full px-4 py-2 border rounded focus:outline-none" />
      </div>
      <div class="mb-4">
        <input
          value="<?= $info->email ?? "" ?>"
          type="email"
          name="email"
          placeholder="Email Address For Applications"
          class="w-full px-4 py-2 border rounded focus:outline-none" />
      </div>
      <button
        class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 my-3 rounded focus:outline-none">
        Save
      </button>
      <a
        href="/"
        class="block text-center w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded focus:outline-none">
        Cancel
      </a>
    </form>
  </div>
</section>

<?= loadPartials("bottom-banner"); ?>
<?= loadPartials("footer") ?>