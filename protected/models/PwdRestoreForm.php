<?php
    class PwdRestoreForm extends CFormModel {
        public $user;
        
        public function rules()
        {
	    return array(
	        array('user', 'required', 'message'=>'Введите Login или E-Mail зарегистрированного пользователя для восстановления пароля'),
	        array('user', 'isexists'),
	    );
        }
        
        public function attributeLabels()
        {
	    return array(
	        'user'=>'Login или E-Mail',
	    );
        }
        
        public function isexists($attribute,$params)
        {
	    if (!$this->hasErrors()) {
		$user = User::model()->find('`login`=:User or `email`=:User', array(':User'=>$this->user));
		if (!isset($user->uid)) {
		    $this->addError('username','Пользователь с указанными данными не найден.');
		}
	    }
        }

    }
    
?>