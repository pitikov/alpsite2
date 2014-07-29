<?php
class PwdRequest extends CFormModel {
  public $password;
  public $password_confirm;
  
  public function rules()
  {
      return array(
          array('password, password_confirm', 'required'),
          array('password_confirm', 'compare', 'compareAttribute'=>'password', 'message'=>'Ввод пароля должен быть повторен в точности'),
      );
  } 
  
  public function attributeLabels()
  {
      return array(
          'password'=>'Введите пароль',
          'password_confirm'=>'Повторите ввод',
      );
  }
}
?>