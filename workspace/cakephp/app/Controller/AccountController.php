<?php
class AccountController extends AppController {
	public $uses = ['User'];
	public function index (){

        $userId = $this->Auth->user('id');
        
        $user = $this->User->findById($userId);
        $this->set('user', $user['User']);
	}

    public function changePassword() {
        $userId = $this->Auth->user('id');
        $user = $this->User->findById($userId);

        if (!$user) {
            $this->Flash->error(__('User not found.'));
            return $this->redirect(array('action' => 'index'));
        }

        if ($this->request->is(['post', 'put'])) {
            $this->User->id = $userId;
            $data = $this->request->data;

            // if new email input
            if (!empty($data['email']) && $data['email'] != $user['User']['email']) {
                $this->User->set('email', $data['email']);
                if ($this->User->saveField('email', $data['email'], ['fieldList' => ['email']])) {
                    $this->Flash->success(__('Email has been updated.'));
                } else {
                    $this->set('errors', $this->User->validationErrors);
                    $this->Flash->error(__('Invalid email address.'));
                    $this->render('index');
                    return;
                }
            }

            // if password input
            if (!empty($data['password']) && !empty($data['confirm_password'])) {
                $this->User->set($data); 

                if ($this->User->save(null, ['fieldList' => ['password', 'confirm_password']])) {
                    $this->Flash->success(__('Password has been updated.'));
                } else {
                    $this->set('errors', $this->User->validationErrors);
                    $this->Flash->error(__('Invalid password.'));
                    $this->render('index');
                    return;
                }
            }

            return $this->redirect(array('action' => 'index'));
        }

        $this->request->data = $user;
        $this->set('user', $user);
    }


}

