<?php
class HomeController extends AppController {
    public $uses = ['User'];

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(['login', 'register', 'register_success']);
    }

    public function index() {
        // Remove commented-out code if not needed
    }

    public function login() {
        $currentUserID = $this->Auth->user('id');
        if ($currentUserID) {
            $this->Flash->error(__(''));
            return $this->redirect(['controller' => 'messages', 'action' => 'index']);
        }

        if ($this->request->is('POST')) {
            $user = $this->User->find('first', [
                'conditions' => [
                    'email' => $this->request->data['email'],
                    'status' => 'Active'
                ]
            ]);

            if ($user && password_verify($this->request->data['password'], $user['User']['password'])) {
                $this->User->id = $user['User']['id'];
                $this->User->saveField('last_login_time', date('Y-m-d H:i:s'));

                if ($this->Auth->login($user['User'])) {
                    return $this->redirect($this->Auth->redirectUrl(['controller' => 'messages', 'action' => 'index']));
                }
            }

            $this->Flash->error(__('Invalid email or password, try again.'));
        }
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

    public function register() {
        $currentUserID = $this->Auth->user('id');
        if ($currentUserID) {
            $this->Flash->error(__('You cannot register while logged in.'));
            return $this->redirect(array('controller' => 'messages', 'action' => 'index'));
        }

        if ($this->request->is('POST')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                // $this->Flash->success(__('Account created.'));

                // Retrieve the newly created user
                $user = $this->User->find('first', array(
                    'conditions' => array(
                        'email' => $this->request->data['email']
                    )
                ));

                $didLogin = $this->Auth->login($user['User']);

                // Update last login time
                $this->User->id = $user['User']['id'];
                $this->User->saveField('last_login_time', date('Y-m-d H:i:s'));



                if ($didLogin) {
                    return $this->redirect($this->Auth->redirectUrl(array('action' => 'register_success')));
                }
            } else {
                $this->set('errors', $this->User->validationErrors);
                $this->Flash->error(__('Failed to create account. Please, try again.'));
            }
        }
    }

    public function register_success() {
        $this->Flash->success(__('Account created.'));
    }
}
