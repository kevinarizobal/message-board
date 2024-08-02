<section class="flex items-center flex-col justify-center min-h-screen">
    <?= $this->Flash->render(); ?>
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <svg class="w-[35px] h-[35px]" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M3 6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-6.616l-2.88 2.592C8.537 20.461 7 19.776 7 18.477V17H5a2 2 0 0 1-2-2V6Zm4 2a1 1 0 0 0 0 2h5a1 1 0 1 0 0-2H7Zm8 0a1 1 0 1 0 0 2h2a1 1 0 1 0 0-2h-2Zm-8 3a1 1 0 1 0 0 2h2a1 1 0 1 0 0-2H7Zm5 0a1 1 0 1 0 0 2h5a1 1 0 1 0 0-2h-5Z" clip-rule="evenodd"/>
        </svg>
        <h1 class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">REGISTER</h1>
    </div>

    <div class="container border shadow rounded p-8 bg-white mx-auto max-w-md">
        <form method="POST" action="<?= $this->Html->url(['action' => 'register']); ?>" autocomplete="off">
            <div class="grid grid-cols-1 gap-6">
                <div class="col-span-1">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                    <input placeholder="abc@example.com" type="email" id="email" name="email" class="block bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                    <?php if (!empty($errors['email'])): ?>
                        <div class="text-red-500 text-sm mt-2"><?= $errors['email'][0]; ?></div>
                    <?php endif; ?>
                </div>

                <div class="col-span-1">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                    <input placeholder="Enter your Full Name" type="text" id="name" name="name" minlength="5" maxlength="20" class="block bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                    <?php if (!empty($errors['name'])): ?>
                        <div class="text-red-500 text-sm mt-2"><?= $errors['name'][0]; ?></div>
                    <?php endif; ?>
                </div>

                <div class="col-span-1">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                    <input type="password" id="password" name="password" class="block bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                    <?php if (!empty($errors['password'])): ?>
                        <div class="text-red-500 text-sm mt-2"><?= $errors['password'][0]; ?></div>
                    <?php endif; ?>
                </div>

                <div class="col-span-1">
                    <label for="confirm_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="block bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                    <?php if (!empty($errors['confirm_password'])): ?>
                        <div class="text-red-500 text-sm mt-2"><?= $errors['confirm_password'][0]; ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="flex justify-center mt-6">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-10 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Register</button>
            </div>
        </form>
    </div>
    
    <div class="flex items-start mb-5 mt-5">
        <div class="flex items-center h-5">
            <label for="terms" class="text-sm font-medium text-gray-900 dark:text-gray-300">Already have an account? <a href="/cakephp/home/login" class="text-blue-600 hover:underline dark:text-blue-500">Login here</a></label>
        </div>
    </div>
</section>
