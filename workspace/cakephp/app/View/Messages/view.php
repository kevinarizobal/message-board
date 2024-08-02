<br><br><br>
<section class="flex h-screen flex-col justify-center items-center w-full">
    <?= $this->Flash->render(); ?>
    <div class="flex items-center gap-1 m-1">
        <a href="/cakephp/profile/view/<?= $recipientID ?> ">
            <img class="w-11 h-11 rounded-full border border-gray-800 cursor-pointer" src="<?= $this->Html->url("/" . $recipientImage); ?>" alt="Sender's Image">
        </a>
        &nbsp;
        <p class="font-bold text-lg dark:text-white"><?= $recipientName ?></p>

    </div>

    <div class="w-full m-5">
        <form class="max-w-md mx-auto" id="findMessageForm" autocomplete="off">
            <label for="findMessageSearch" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="search" id="findMessageSearch" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search in conversation" required />
                <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
            </div>
        </form>
    </div>

    <div id="messageContainer" class="shadow relative w-full max-w-2xl overflow-y-scroll bg-white border border-gray-100 rounded-lg dark:bg-gray-800 dark:border-gray-600 h-96 p-5">
        <?php foreach ($messageDetails as $messageDetail) : ?>
            <?php if ($messageDetail["messages"]["receiver_id"] == $currentUserID) : ?>
                <div id="sender" class="message flex items-start gap-2.5 mb-5">
                    <a href="/cakephp/profile/view/<?= $messageDetail["messages"]["sender_id"] ?>">
                        <img class="w-8 h-8 rounded-full border border-gray-800 cursor-pointer" src="<?= $this->Html->url("/" . $messageDetail["sender_users"]["profile_image"]); ?>" alt="Sender's Image">
                    </a>
                    <div class="flex flex-col leading-1.5 p-3 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl dark:bg-gray-700">
                        <div class="flex items-center space-x-2 rtl:space-x-reverse">
                            <span class="text-xs font-normal text-gray-500 dark:text-gray-400">
                                <?= date('F j, Y g:i A', strtotime($messageDetail['messages']['created_at'])); ?>
                            </span>
                        </div>
                        <p id="" class="recipientUserMessage text-sm font-normal py-2.5 text-gray-900 dark:text-white break-all">
                            <?= $messageDetail["messages"]["message"]; ?>
                        </p>
                    </div>
                </div>
            <?php elseif ($messageDetail["messages"]["sender_id"] == $currentUserID) : ?>
                <div class="message flex justify-end items-center gap-2.5 mb-5">
                    <div class="flex flex-col leading-1.5 p-3 border-gray-200 bg-blue-600 rounded-s-xl rounded-ee-xl dark:bg-blue-600">
                        <div class="flex items-center space-x-2 rtl:space-x-reverse">
                            <span class="text-xs font-normal text-gray-300 dark:text-gray-300">
                                <?= date('F j, Y g:i A', strtotime($messageDetail['messages']['created_at'])); ?>
                            </span>
                        </div>
                        <p id="" class="currentUserMessage text-sm font-normal py-2.5 text-white dark:text-white break-all">
                            <?= $messageDetail["messages"]["message"]; ?>
                        </p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <img class="w-8 h-8 rounded-full border border-gray-800 cursor-pointer" src="<?= $this->Html->url("/" . $messageDetail["sender_users"]["profile_image"]); ?>" alt="Sender's Image">
                        <!-- 3dots -->
                        <button id="dropdownMenuIconButton<?= $messageDetail['messages']['id']; ?>" data-dropdown-toggle="msgOption<?= $messageDetail['messages']['id']; ?>" data-dropdown-placement="bottom-start" class="inline-flex self-center items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-900 dark:focus:ring-gray-600" type="button">
                            <svg class="w-4 h-4 text-gray-500 dark:text-dark-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                                <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 0 1 3 0Z" />
                            </svg>
                        </button>
                    </div>
                    <div id="msgOption<?= $messageDetail['messages']['id']; ?>" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-40 dark:bg-gray-700 dark:divide-gray-600">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuIconButton<?= $messageDetail['messages']['id']; ?>">
                            <li>
                                <p id="deleteButton<?= $messageDetail['messages']['id'] ?>" data-modal-target="deleteModal<?= $messageDetail['messages']['id'] ?>" data-modal-toggle="deleteModal<?= $messageDetail['messages']['id'] ?>" class="cursor-pointer block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Delete</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div id="deleteModal<?= $messageDetail['messages']['id'] ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                    <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                        <!-- Modal content -->
                        <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                            <button type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="deleteModal<?= $messageDetail['messages']['id'] ?>">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                            <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="mb-4 text-gray-500 dark:text-gray-300">Are you sure you want to delete this message?</p>
                            <div class="flex justify-center items-center space-x-4">
                                <button data-modal-toggle="deleteModal<?= $messageDetail['messages']['id'] ?>" type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                    Cancel
                                </button>
                                <a id="deleteMessage" href="/cakephp/messages/delete/<?= $messageDetail['messages']['id'] ?>" data-modal-toggle="deleteModal<?= $messageDetail['messages']['id'] ?>" class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                    Okay
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <div class=" w-full shadow max-w-2xl mt-2  bg-white border border-gray-100 rounded-lg dark:bg-gray-800 dark:border-gray-600">
        <form id="replyForm" method="post" autocomplete="off">
            <div class="flex items-center px-3 py-2 rounded-lg bg-gray-50 dark:bg-gray-700">
                <input type="text" name="reply" autofocus id="chat" rows="1" class="block mx-4 p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter your message..."></input>
                <button type="submit" class="inline-flex justify-center p-2 text-blue-600 rounded-full cursor-pointer hover:bg-blue-100 dark:text-blue-500 dark:hover:bg-gray-600">
                    <svg class="w-5 h-5 rotate-90 rtl:-rotate-90" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                        <path d="m17.914 18.594-8-18a1 1 0 0 0-1.828 0l-8 18a1 1 0 0 0 1.157 1.376L8 18.281V9a1 1 0 0 1 2 0v9.281l6.758 1.689a1 1 0 0 0 1.156-1.376Z" />
                    </svg>
                    <span class="sr-only">Send message</span>
                </button>
            </div>
        </form>
    </div>
</section>


<script>
    $(document).ready(function() {
        const messageContainer = $('#messageContainer');
        messageContainer.scrollTop(messageContainer[0].scrollHeight);
        const param = <?= $this->request->params['pass'][0] ?>;

        $(document).on('submit', '#replyForm', function(e) {
            e.preventDefault();

            const param = <?= $this->request->params['pass'][0] ?>

            $.ajax({
                url: '/cakephp/messages/reply/' + param,
                type: 'POST',
                data: {
                    reply: $('#chat').val()
                },
                success: (response) => {
                    response = JSON.parse(response);
                    if (response.status === 'success') {
                        $('#chat').val('');
                        $.get('/cakephp/messages/view/' + param, (data) => {
                            const newMessages = $(data).find('#messageContainer').html();

                            $('#messageContainer').html(newMessages);
                            messageContainer.scrollTop(messageContainer[0].scrollHeight);

                            initFlowbite();
                        });
                    } else {
                        alert('Failed to send message.');
                    }
                },
                error: () => {
                    alert('Error sending message.');
                }
            });
        });


        $(document).ready(function() {
            const messageContainer = $('#messageContainer');
            messageContainer.scrollTop(messageContainer[0].scrollHeight);
            const param = <?= $this->request->params['pass'][0] ?>;

            // Delete message
            $(document).on('click', '#deleteMessage', function(e) {
                e.preventDefault();
                const $this = $(this);

                $.ajax({
                    url: $this.attr('href'),
                    type: 'POST',
                    success: function(response) {
                        response = JSON.parse(response);
                        if (response.status === 'success') {
                            // Find the message div and fade out
                            const messageId = $this.closest('.message').attr('id');
                            $(`#${messageId}`).fadeOut('slow', function() {
                                $(this).remove();
                            });
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert('Error deleting message.');
                    }
                });
            });
        });

        
        $(document).on('submit', '#findMessageForm', (e) => {
            e.preventDefault();
            const findMessage = $('#findMessageSearch').val().trim();
            const param = <?= $this->request->params['pass'][0] ?>;

            if (findMessage === '') {
                alert('Please enter a search term.');
                return;
            }

            $.ajax({
                url: '/cakephp/messages/findMessage/',
                type: 'GET',
                data: {
                    findMessage: findMessage,
                    recipientID: param
                },
                dataType: 'json',
                success: (response) => {
                    if (response.status === 'success') {

                        $('.currentUserMessage, .recipientUserMessage').each(function() {
                            $(this).html($(this).text());
                        });


                        $('.currentUserMessage, .recipientUserMessage').each(function() {
                            const text = $(this).text();
                            const regex = new RegExp(findMessage, 'gi');
                            const newHtml = text.replace(regex, match => `<span class="bg-yellow-200">${match}</span>`);
                            $(this).html(newHtml);
                        });

                        initFlowbite();
                    } else {
                        alert(response.message);
                    }
                },
                error: () => {
                    alert('An error occurred while searching for messages.');
                }
            });
        });

        let isUserScrolling = false;
        let isHighlighted = false;


        messageContainer.on('scroll', () => {
            const scrollHeight = messageContainer[0].scrollHeight;
            const scrollTop = messageContainer.scrollTop();
            const clientHeight = messageContainer[0].clientHeight;

            isUserScrolling = (scrollTop + clientHeight < scrollHeight - 10); //true
            isHighlighted = ($('.currentUserMessage, .recipientUserMessage').find('span').length > 0);
        });

        setInterval(() => {
            $.get('/cakephp/messages/view/' + param, (data) => {
                const newMessages = $(data).find('#messageContainer').html();
                const $newMessages = $(newMessages);

                //highlights
                $newMessages.find('.currentUserMessage, .recipientUserMessage').each(function() {
                    const text = $(this).text();
                    const regex = new RegExp($('#findMessageSearch').val().trim(), 'gi');
                    const newHtml = text.replace(regex, match => `<span class="bg-yellow-200">${match}</span>`);
                    $(this).html(newHtml);
                });

                messageContainer.html($newMessages);

                if (!isUserScrolling) {
                    initFlowbite();
                    messageContainer.scrollTop(messageContainer[0].scrollHeight);
                }
            });
            initFlowbite();
        }, 3000);

    });
</script>