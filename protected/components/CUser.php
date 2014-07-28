<?php 
    class CUser extends CWebUser {
        
        public function isAdmin()
        {
	    if (Yii::app()->user->getName() === 'admin' )  return true;
	    else return false;
        }
        
        public function isFederationMember()
        {
	    if (Yii::app()->user->getName() === 'admin' )  return true;
	    else return false;

        }
    }
?>