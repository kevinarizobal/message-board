<br><br>
<section class="flex items-center flex-col justify-center min-h-screen dark:bg-gray-900">
    <h1 class="text-black dark:text-white text-5xl mb-10 font-medium mt-5">User profile</h1>
    <div class="col-span-full xl:col-auto w-1/5">
        <div class="bg-white dark:bg-gray-800 shadow-lg shadow-gray-200 dark:shadow-gray-900 rounded-2xl p-4 mb-6 w-full">
            <div class="sm:flex xl:block sm:space-x-4 xl:space-x-0">
                <img class="rounded w-32 h-32 mx-auto"
                src="<?= !empty($user['profile_image']) ? $this->Html->url('/' . $user['profile_image']) : $this->Html->url('/' . $currentUser['profile_image']); ?>"
                alt="Profile Image">
                <div>
                    <h2 class="text-xl text-center font-bold text-gray-900 dark:text-gray-100"><?= isset($user['name']) ? h($user['name']) : $currentUser['name']; ?></h2>
                    <ul class="mt-2 space-y-1">
                        <li class="flex items-center text-sm font-normal text-gray-500 dark:text-gray-400">
                            Gender: <?= $currentUser['gender']; ?>
                        </li>
                        </li>
                        <li class="flex items-center text-sm font-normal text-gray-500 dark:text-gray-400">
                            
                            Birthdate: <?= date('F j, Y', strtotime($currentUser['birthdate'])) ?>
                        </li>
                        <li class="flex items-center text-sm font-normal text-gray-500 dark:text-gray-400">
                            Joined: <?= date('F j, Y g:i A', strtotime($currentUser['created_at'])) ?>
                        </li>
                        
                        <li class="flex items-center text-sm font-normal text-gray-500 dark:text-gray-400">
                            Last login: <?= date('F j, Y g:i A', strtotime($currentUser['last_login_time'])) ?>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mb-4 sm:flex xl:block">
                <div class="sm:flex-1">
                    <address class="text-sm not-italic font-normal text-gray-500 dark:text-gray-400">
                        <div class="mt-4">Email address</div>
                        <a class="text-sm font-medium text-gray-900 dark:text-gray-100"
                            href="mailto:webmaster@flowbite.com"><?= $currentUser['email'] ?> </a>
                        <div class="mt-4">Hobby</div>
                        <div class="mb-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                            <?= $currentUser['hobby'] ?>
                        </div>
                        
                    </address>
                </div>
            </div>
        </div>
    </div>
</section>
