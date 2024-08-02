<section class="flex items-center flex-col justify-center min-h-screen pt-36 pb-8">
    <?= $this->Flash->render(); ?>
    <h1 class="text-black dark:text-white text-4xl mb-8 font-medium">Profile</h1>
    <div class="container bg-white shadow-lg max-w-md mx-auto p-6 rounded-lg">
        <input type="hidden" name="update_name" value="1">
        <form method="post" action="<?= $this->Html->url(['action' => 'updateProfile']); ?>" enctype="multipart/form-data">
            <div class="flex justify-center mb-6">
                <img id="profileImagePreview" class="rounded-full w-24 h-24" src="<?= !empty($user['profile_image']) ? $this->Html->url('/' . $user['profile_image']) : $this->Html->url('/' . $currentUser['profile_image']); ?>" alt="Profile Image">
            </div>
            <div class="mb-5">
                <label for="profile_image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Upload file</label>
                <input id="profile_image" type="file" name="profile_image"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                    onchange="previewImage(event)">
            </div>
            <div class="mb-5">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                <input value="<?= isset($user['name']) ? h($user['name']) : $currentUser['name']; ?>" type="text" id="name" name="name"
                    class="block bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                <? if (!empty($errors['name'])): ?>
                <div class="text-red-500"><?= $errors['name'][0]; ?></div>
                <? endif; ?>
            </div>
            <div class="mb-5">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email Address</label>
                <input value="<?= isset($user['email']) ? h($user['email']) : $currentUser['email']; ?>" type="text" id="email" name="email"
                    class="block bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly />
                <? if (!empty($errors['email'])): ?>
                <div class="text-red-500"><?= $errors['email'][0]; ?></div>
                <? endif; ?>
            </div>
            <div class="mb-5">
                <label for="birthdate" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Birthdate</label>
                <input id="birthdate" name="birthdate" datepicker datepicker-format="yyyy/mm/dd" datepicker-autohide
                    type="text" value="<?= isset($user['birthdate']) ? h($user['birthdate']) : $currentUser['birthdate']; ?>"
                    class="block bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
            </div>
            <div class="mb-5">
                <label for="gender" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>
                <div class="flex items-center mb-4">
                    <div class="flex items-center mr-6">
                        <input id="male" type="radio" value="Male" name="gender"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                            <?= (isset($user['gender']) && $user['gender'] == 'M') ? 'checked' : ($currentUser['gender'] == 'M' ? 'checked' : ''); ?>>
                        <label for="male" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Male</label>
                    </div>
                    <div class="flex items-center">
                        <input id="female" type="radio" value="Female" name="gender"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                            <?= (isset($user['gender']) && $user['gender'] == 'F') ? 'checked' : ($currentUser['gender'] == 'F' ? 'checked' : ''); ?>>
                        <label for="female" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Female</label>
                    </div>
                </div>
            </div>
            <div class="mb-5">
                <label for="hobby" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hobby</label>
                <textarea name="hobby" id="hobby" rows="4"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Write your hobbies here..."><?= isset($user['hobby']) ? h($user['hobby']) : $currentUser['hobby']; ?></textarea>
            </div>
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update</button>
        </form>
    </div>
</section>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profileImagePreview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
</script>
