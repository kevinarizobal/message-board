<section class="flex h-screen flex-col justify-center items-center w-full">
   <h1 class="text-black dark:text-white text-5xl mb-10 font-medium">Create new message</h1>
   <?= $this->Flash->render(); ?>
   <form class="w-2/6 flex gap-2 flex-col" method="post" action="<?= $this->Html->url(array('action' => 'create')); ?>">

         <select id="recipients" name="recipient" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full h-16 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value=""></option>
         </select>

         <label for="chat" class="sr-only">Your message</label>
         <div class="flex flex-col items-stretch px-4 py-3 rounded-lg bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 shadow-md">
            <textarea name="content" id="chat" rows="4" class="block w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 p-3 mb-2" placeholder="Enter your message..."></textarea>
            <div class="flex justify-end">
               <button type="submit" class="items-center p-2 shadow text-white rounded-lg cursor-pointer bg-blue-500">
                  Send Message
               </button>
            </div>
         </div>
   </form>
</section>
<script>
   $(document).ready(function() {
      $('#recipients').select2({
         placeholder: 'Search for a recipient',
         allowClear: true,
         minimumInputLength: 1,
         ajax: {
            url: '/cakephp/messages/getUsers',
            dataType: 'json',
            data: function(params) {
               return {
                  term: params.term // search term
               };
            },
            processResults: function(data) {
               return {
                  results: data
               };
            },
            cache: true
         },
         templateResult: function(data) {
            if (!data.id) {
               return data.text; // This is the placeholder (i.e., "Choose recipient")
            }
            const imagePath = '/cakephp/app/webroot/files/profile_images/' + data.image;
            const span = $(
               "<span><img src='" + imagePath + "' class='inline-block mr-2 w-6 h-6 rounded-full' />" + data.text + " | " + data.email + "</span>"
            );
            return span;
         },

      });
   });
</script>