<?php
class MessagesController extends AppController {
	public $uses = ['Message', 'User'];
	
	// For Main/Index Page of Message (Pagination)
	public function index($page = 1) {
		$currentUserID = $this->Auth->user('id');
		$limit = 2; // Number of messages per page
		$offset = ($page - 1) * $limit;

		$currentUsersMessageList = $this->Message->query(
			'SELECT messages.*, users.name, users.profile_image, users.id FROM messages
			JOIN (
				SELECT MAX(id) as max_id, 
				CASE WHEN sender_id = ' . $currentUserID . ' THEN receiver_id ELSE sender_id END as other_user_id 
				FROM messages
				WHERE (sender_id = ' . $currentUserID . ' OR receiver_id = ' . $currentUserID . ') and (messages.status = 1)
				GROUP BY CASE WHEN sender_id = ' . $currentUserID . ' THEN receiver_id ELSE sender_id END
			) as mm ON messages.id = mm.max_id
			JOIN users ON messages.sender_id = users.id OR messages.receiver_id = users.id
			WHERE users.id != ' . $currentUserID . ' ORDER BY messages.created_at DESC
			LIMIT ' . $limit . ' OFFSET ' . $offset
		);

		$this->set('messages', $currentUsersMessageList);
		$this->set('currentUserID', $currentUserID);
		$this->set('page', $page);
	}
	
	// For Creating a New Message
	public function create() {

		$currentUser = $this->Auth->user('id');

		$users = $this->User->find('all', array(
			'conditions' => array(
				'User.id !=' => $currentUser,
				'User.status' => 'Active'
			)
		));
		$this->set('users', $users);

		if ($this->request->is('post')) {

			$recipientID = $this->request->data['recipient'];
			$message = $this->request->data['content'];

			if (!$message) {
				$this->Flash->error(__('Message cannot be empty.'));
				$this->redirect(array('action' => 'create'));
			}

			if (!$recipientID) {
				$this->Flash->error(__('Recipient cannot be empty.'));
				$this->redirect(array('action' => 'create'));
			}

			$data = array(
				'sender_id' => $currentUser,
				'receiver_id' => $recipientID,
				'message' => $message,
				'created_at' => date('Y-m-d H:i:s')
			);

			$this->Message->create();
			$this->Message->save($data);

			$this->Flash->success(__('Message sent.'));
			return $this->redirect(array('action' => 'view', $recipientID));
		}
	}

	// Display Messages From Sender to Receiver or Receiver to Sender

	public function view($id = null) {
		$currentUserID = $this->Auth->user('id');
		$recipientID = $id;

		if ($recipientID == $currentUserID) {
			$this->Flash->error(__('You cannot send a message to yourself.'));
			return $this->redirect(array('action' => 'index'));
		}

		$messageDetails = $this->Message->query(
			'SELECT messages.*, sender_users.name as sender_name, sender_users.profile_image, receiver_users.name as receiver_name, receiver_users.profile_image
			FROM messages
			JOIN users as sender_users ON sender_users.id = messages.sender_id
			JOIN users as receiver_users ON receiver_users.id = messages.receiver_id
			WHERE ((messages.sender_id = ' . $currentUserID . ' AND messages.receiver_id = ' . $recipientID . ') 
			OR (messages.sender_id = ' . $recipientID . ' AND messages.receiver_id = ' . $currentUserID . '))
			AND (messages.status = 1)
			ORDER BY messages.created_at ASC'
		);

		$recipientInfo = $this->User->query(
			'SELECT name, profile_image FROM users WHERE id = ' . $recipientID
		);

		$this->set('messageDetails', $messageDetails);
		$this->set('currentUserID', $currentUserID);
		$this->set('recipientID', $recipientID);

		$this->set('recipientImage', $recipientInfo[0]['users']['profile_image']);
		$this->set('recipientName', $recipientInfo[0]['users']['name']);
	}

	// Insert/Reply Message to User

	public function reply($id = null) {
		$currentUser = $this->Auth->user('id');
		$recipientID = $id;

		if ($this->request->is('post')) {
			$message = $this->request->data['reply'];

			if (empty($message)) {
				$this->Flash->error(__('Message cannot be empty.'));
				$this->render(array('action' => 'view', $recipientID));
			}

			$data = array(
				'sender_id' => $currentUser,
				'receiver_id' => $recipientID,
				'message' => $message,
				'created_at' => date('Y-m-d H:i:s')
			);

			$this->Message->create();
			$this->Message->save($data);

			if ($this->Message->save($data)) {
				$response = array(
					'status' => 'success',
					'message' => 'Message sent.',
					'data' => $data

				);

				echo json_encode($response);
				die();
			} else {
				$this->Flash->error(__('Message was not sent.'));
				return $this->redirect(array('action' => 'view', $recipientID));
			}
		}
	}

	public function delete($id = null) {
		$this->autoRender = false;
		$this->response->type('json');
	
		if (!$id) {
			throw new NotFoundException(__('Invalid message'));
		}
	
		$message = $this->Message->findById($id);
	
		if (!$message) {
			$response = array(
				'status' => 'error',
				'message' => 'Message not found.',
			);
		} else {
			$currentUserID = $this->Auth->user('id');
			if ($message['Message']['sender_id'] == $currentUserID || $message['Message']['receiver_id'] == $currentUserID) {
				// Soft delete by setting status to 0
				$message['Message']['status'] = 0;
				$this->Message->save($message);
	
				$response = array(
					'status' => 'success',
					'message' => 'Message deleted.',
				);
			} else {
				$response = array(
					'status' => 'error',
					'message' => 'You are not authorized to delete this message.',
				);
			}
		}
	
		$this->response->body(json_encode($response));
	}

	public function deleteAll($id = null) {
		$this->autoRender = false;
		$this->response->type('json');
	
		if (!$id) {
			$response = array(
				'status' => 'error',
				'message' => 'Invalid message ID.',
			);
			echo json_encode($response);
			return;
		}
	
		$message = $this->Message->findById($id);
	
		if (!$message) {
			$response = array(
				'status' => 'error',
				'message' => 'Message not found.',
			);
		} else {
			$currentUserID = $this->Auth->user('id');
			if ($message['Message']['sender_id'] == $currentUserID || $message['Message']['receiver_id'] == $currentUserID) {
				// Soft delete the message itself
				$this->Message->delete($id);
	
				// Assuming you have a Conversation model linked to Message
				$this->Conversation->deleteAll(array('Conversation.message_id' => $id), false);
	
				$response = array(
					'status' => 'success',
					'message' => 'Message and related conversations deleted.',
				);
			} else {
				$response = array(
					'status' => 'error',
					'message' => 'You are not authorized to delete this message.',
				);
			}
		}
	
		echo json_encode($response);
	}
	
	// Search Message Conversation

	public function findMessage() {
		$this->autoRender = false;

		$recipientID = $this->request->query['recipientID'];
		$currentUserID = $this->Auth->user('id');
		$word = $this->request->query['findMessage'];

		$foundMessages = $this->Message->query('SELECT Message.message 
                    FROM messages AS Message 
                    WHERE Message.status = 1 
                    AND Message.sender_id = ' . $currentUserID . ' 
                    AND Message.receiver_id = ' . $recipientID . '
                    AND Message.message LIKE ' . "'%" . $word . "%'");

		if ($foundMessages) {
			$response = array(
				'status' => 'success',
				'message' => 'Messages found.',
				'data' => $foundMessages
			);
		} else {
			$response = array(
				'status' => 'error',
				'message' => 'No messages found.'
			);
		}

		$this->response->type('json');
		$this->response->body(json_encode($response));
	}

	// Search for Other Receipient/User

	public function getUsers() {
		$this->autoRender = false;
		$currentUserID = $this->Auth->user('id');
		$term = isset($this->request->query['term']) ? $this->request->query['term'] : '';
	
		// If term is empty, return an empty JSON array
		if (empty($term)) {
			return json_encode([]);
		}
	
		$users = $this->User->find('all', array(
			'conditions' => array(
				'OR' => array(
					'LOWER(User.name) LIKE' => '%' . strtolower($term) . '%',
					'LOWER(User.email) LIKE' => '%' . strtolower($term) . '%'
				),
				'User.status' => 'Active',
				'User.id !=' => $currentUserID
			),
			'fields' => array('User.id', 'User.name', 'User.email', 'User.profile_image')
		));
	
		$results = array();
		foreach ($users as $user) {
			$imageFile = basename($user['User']['profile_image']);
			$results[] = array(
				'id' => $user['User']['id'],
				'text' => $user['User']['name'],
				'email' => $user['User']['email'],
				'image' => $imageFile
			);
		}
	
		return json_encode($results);
	}
	
}
