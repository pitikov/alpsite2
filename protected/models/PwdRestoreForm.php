<?php
    class PwdRestoreForm extends CFormModel {
        public $user;
        
        public function rules()
        {
	    return array(
	        array('user', 'required', 'message'=>'Введите Login или E-Mail зарегистрированного пользователя для восстановления пароля'),
	        array('user', 'isexists', 'message'=>'Пользователь с указанными данными не найден'),
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
	    if (strlen($this->user) > 0 ) {
		$users = User::model()->findAll('`login`=:User or `email`=:User', array(':User'=>$this->user));
		if (count($users) === 0) $this->addError('username','Пользователь с указанными данными не найден.');
	    }
        }

    }
    
?>