<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class User extends AppModel {
    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }
        return true;
    }
    
    public $validate = array(
        'email' => array(
            'validEmail' => array(
                'rule' => 'email',
                'message' => 'Please enter a valid email address.',
                'required' => true,
                
            ),
            'uniqueEmail' => array(
                'rule' => 'isUnique',
                'message' => 'This email is already taken.',
                // 'on' => 'update'  //only on registration
            )
        ),
        'name' => array(
            'nameLength' => array(
                'rule' => array('between', 5, 20),
                'message' => 'Name must be between 5 and 20 characters long.',
                'required' => true,
                'allowEmpty' => false,
                'on' => array('create', 'update')  // applies to both registration and update
            )
        ),
        'password' => array(
            'complexPassword' => array(
                'rule' => array(
                    'custom',
                    '/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{6,}$/'
                ),
                'message' => 'Password must be at least 6 characters long and contain at least one uppercase letter, one number, and one special character.',
                'required' => true,  
                // 'on' => 'update' 
            )
        ),
        'confirm_password' => array(
            'matchPasswords' => array(
                'rule' => 'validatePasswords',
                'message' => 'Passwords do not match.',
                'required' => true,
                // 'on' => 'update'
            )
        )
    );


    public function validatePasswords($data) {
        if ($this->data['User']['password'] !== $data['confirm_password']) {
            return false;
        }
        return true;
    }

}
