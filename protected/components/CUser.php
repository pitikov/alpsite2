<?php 
    class CUser extends CWebUser {
	private $_model = null;
	
	public function init()
	{
	    $this->loginUrl = array('/member/login');
	    parent::init();
	}
	
	
	private function getModel()
	{
	    if($this->_model === null && !$this->isGuest) {
		$this->_model = User::model()->findByPk($this->id);
	    }
	    return $this->_model;
	}
	
	public function model()
	{
	    return $this->getModel();
	}
	
	protected function afterLogout()
	{
	    $this->_model = null;
	    parent::afterLogout();
	}
	
	public function getRole()
	{
	    $role = 'guest';
	    if (!$this->isGuest) {
		$role = 'user';
		if ($user = $this->getModel()) {
		    $fmemeber = $user->federationMembers;
		    if ((count($fmemeber)>0) && $user->isAdmin()) {
			$role = 'fapoadmin';
		    } else if (count($fmemeber)>0) {
			$role = 'fapo';
		    } else if ($user->isAdmin()) {
			$role = 'admin';
		    }
		}
	    }
	    return $role;
	}
    }
?>