<section class="flex items-center flex-col justify-center min-h-screen">
    <h1 class="text-black dark:text-white text-5xl mb-10 font-medium ">Message List</h1>

    <div id="messageContainer" class="bottom-4 shadow relative w-full max-w-4xl overflow-y-scroll bg-white border border-gray-100 rounded-lg dark:bg-gray-700 dark:border-gray-600 h-96 mx-auto">
        <ul id="messageList">
            <?php foreach ($messages as $message): ?>
                <li class="message-row border-b border-gray-100 dark:border-gray-600 flex hover:bg-gray-50 dark:hover:bg-gray-800">
                    <a href="/cakephp/profile/view/<?= htmlspecialchars($message['users']['id'], ENT_QUOTES, 'UTF-8') ?>" class="flex self-center ml-2">
                        <img class="me-3 rounded-full w-11 h-11 border border-gray-800 cursor-pointer" src="<?= htmlspecialchars($this->Html->url('/' . $message['users']['profile_image']), ENT_QUOTES, 'UTF-8') ?>" alt="User Avatar">
                    </a>

                    <a href="/cakephp/messages/view/<?= htmlspecialchars($message['users']['id'], ENT_QUOTES, 'UTF-8') ?>" class="flex justify-start w-full px-2 py-3">
                        <div>
                            <p class="font-semibold text-md text-gray-900 dark:text-white">
                                <?= htmlspecialchars($message['users']['name'], ENT_QUOTES, 'UTF-8') ?>
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                <?php if ($message['messages']['sender_id'] == $currentUserID): ?>
                                    <span class="font-normal text-gray-900 dark:text-gray-200">You:</span>
                                <?php else: ?>
                                    <span class="font-normal text-gray-900 dark:text-gray-200"><?= htmlspecialchars($message['users']['name'], ENT_QUOTES, 'UTF-8') ?>:</span>
                                <?php endif; ?>
                                <?php 
                                    $maxLength = 35;
                                    $fullMessage = htmlspecialchars($message['messages']['message'], ENT_QUOTES, 'UTF-8');
                                    $shortMessage = (strlen($fullMessage) > $maxLength) ? substr($fullMessage, 0, $maxLength) . '...' : $fullMessage;
                                    echo $shortMessage;
                                ?>
                            </p>
                            <p>
                                <span class="text-xs font-normal text-gray-500 dark:text-gray-400">
                                    <?= date('F j, Y g:i A', strtotime($message['messages']['created_at'])); ?>
                                </span>
                            </p>
                        </div>
                    </a>    
                    <button class="delete-conversation-btn" data-user-id="<?= $message['users']['id'] ?>" aria-label="Delete Conversation">
                        <svg class="w-6 h-6 text-gray-500 dark:text-gray-400 hover:text-red-500 dark:hover:text-red-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </li> 
            <?php endforeach; ?>
        </ul>
    </div>
    <br><br><br>
    <div class="absolute bottom-20 left-0 right-0 flex justify-center p-4 dark:bg-gray-700">
        <button id="showMoreBtn" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700">
            Show More
        </button>
    </div>
    <div id="write" class="absolute bottom-4 left-4 z-50 w-16 h-16 bg-white border dark:bg-gray-700 dark:divide-gray-600 rounded-full shadow">
        <a href="/cakephp/messages/create" class="inline-flex items-center justify-center font-medium p-2 group">
            <svg class="w-10 h-10 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
            </svg>
        </a>
    </div>
</section>

<script>
    let page = <?= $page ?>;

    document.getElementById('showMoreBtn').addEventListener('click', function() {
        page++;
        fetch(`/cakephp/messages/index/${page}`)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newMessages = doc.querySelector('#messageList').innerHTML;
                document.querySelector('#messageList').innerHTML += newMessages;
            })
            .catch(error => console.error('Error fetching messages:', error));
    });

    function updateMessages() {
        fetch('/cakephp/messages/index')
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newMessages = doc.querySelector('#messageList').innerHTML;
                document.querySelector('#messageList').innerHTML = newMessages;
            })
            .catch(error => console.error('Error fetching messages:', error));
    }
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-conversation-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const userId = this.getAttribute('data-user-id');
            
            // Confirm deletion
            if (confirm('Are you sure you want to delete this conversation?')) {
                fetch(`/cakephp/messages/deleteConversation/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Update messages
                        updateMessages();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error('Error deleting conversation:', error));
            }
        });
    });
});
</script>
