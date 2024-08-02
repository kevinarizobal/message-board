<?php
class UsersController extends AppController {
    // public $uses = ['User'];
	// public function beforeFilter() {
    //     parent::beforeFilter();

    
    // }

    public function view($id = null) {
        
        $users = $this->User->query(
            'SELECT * FROM users where id =' . $id
        );

        $this->set('users', $users);
        
        echo "<pre>";
        print_r($users);
        die();
    }

}