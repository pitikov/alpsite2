<?php 
    class CUser extends CWebUser {
        
        public function isAdmin()
        {
	    return true;
        }
    }
?>