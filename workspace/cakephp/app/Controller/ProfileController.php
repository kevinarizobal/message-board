<?php
class ProfileController extends AppController {


    public $validate = array(
        'name' => array(
            'nameLength' => array(
                'rule' => array('between', 5, 20),
                'message' => 'Name must be between 5 and 20 characters long.',
                'required' => true,
                'allowEmpty' => false,
                'on' => 'update'  
            )
        )
    );
    
	public $uses = ['User'];

	public function index (){
        $userId = $this->Auth->user('id');
        
        $user = $this->User->findById($userId);

        $this->set('user', $user['User']);

        // echo "<pre>";
        // var_dump($user['User']);
        // die();
	}

    public function updateProfile() {
        // $this->autoRender = false;
        $this->render(false);
        $this->User->validate = $this->validate;
        
        $userId = $this->Auth->user('id');

        $user = $this->User->findById($userId);

        if (!$user) {
            $this->Flash->error(__('User not found.'));
            return $this->redirect(array('action' => 'index'));
        }

        if ($this->request->is('post')) {

            $this->User->id = $userId;

            $this->User->set($this->request->data);
            if ($this->User->validates(array('fieldList' => ['name']))) {
                // File upload handling
                if (!empty($_FILES['profile_image']['name'])) {
                    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    $fileMimeType = mime_content_type($_FILES['profile_image']['tmp_name']);

                    if (in_array($fileMimeType, $allowedMimeTypes)) {
                        $uploadDir = WWW_ROOT . 'files/profile_images/';
                        $uploadFile = $uploadDir . basename($_FILES['profile_image']['name']);

                        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $uploadFile)) {
                            $this->request->data['User']['profile_image'] = 'files/profile_images/' . basename($_FILES['profile_image']['name']);
                        } else {
                            $this->Flash->error(__('File upload failed. Please, try again.'));
                            return $this->redirect(array('action' => 'index'));
                        }
                    } else {
                        $this->Flash->error(__('Invalid file type. Only JPG, PNG, and GIF files are allowed.'));
                        return $this->redirect(array('action' => 'index'));
                    }
                }

                if ($this->User->save($this->request->data)) {
                    $this->Flash->success(__('Your profile has been updated.'));
                    return $this->redirect(array('action' => 'index'));
                    $this->redirect('index');
                } else {
                    $this->Flash->error(__('Unable to update your profile. Please, try again.'));
                    return $this->redirect(array('action' => 'index'));
                }
            } else {
                $this->set('errors', $this->User->validationErrors);
                $this->render('index');
            }
        }

        if (!$this->request->is('post') && !$this->request->is('put')) {
            $this->request->data = $user;
        }
        $this->set('user', $user);
    }


    public function view() {

	}

    

    public function delete($id = null) {
        // Prior to 2.5 use
        // $this->request->onlyAllow('post');

        $this->request->allowMethod('post');

        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Flash->success(__('User deleted'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Flash->error(__('User was not deleted'));
        return $this->redirect(array('action' => 'index'));
    }


    
    public function beforeFilter(){
        parent::beforeFilter();
        
        // global restriction
        // $this->Auth->allow('index', 'view', 'add');
        
        
    }


}