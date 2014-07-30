<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id = null;
	
	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */	
	public function authenticate()
	{
		$users = User::model()->findAll("login=:VALUE or email=:VALUE", array(':VALUE'=>$this->username));
		$this->errorCode = self::ERROR_PASSWORD_INVALID;
		if (count($users)>0) {
		  /// @todo Обработать все вхождения на соответствие
		  foreach($users as $user) {
		      if ($user->pwdhash == crypt($this->password, $user->pwdhash)) {
			  $this->errorCode = self::ERROR_NONE;
			  $this->username = $user->name;
			  $this->_id = $user->uid;
			  
			  break;
		      }
		  }
		} else {
		  $this->errorCode=self::ERROR_USERNAME_INVALID;
		}
		return !$this->errorCode;
	}
	
	public function getId()
	{
	    return $this->_id;
	}
}