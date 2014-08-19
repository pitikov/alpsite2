<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $uid
 * @property string $login
 * @property string $pwdhash
 * @property string $name
 * @property string $email
 * @property string $dob
 * @property string $regdata
 * @property string $sign
 * @property string $avatar
 * @property string $role
 *
 * The followings are the available model relations:
 * @property Article[] $articles
 * @property CCalendar[] $cCalendars
 * @property Comment[] $comments
 * @property FederationMember[] $federationMembers
 * @property Pwdrestore $pwdrestore
 * @property Tags[] $tags
 * @property Mail[] $mail
 */
class User extends CActiveRecord
{
	public $regdate;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			/// @todo Для имен пользователя разрешить только буквы русского и английского алфавита, пробел и тире
			array('login, name, email', 'required'),
			array('login', 'length', 'min'=>6,'max'=>16),
			array('login', 'match', 'pattern'=>'/^[A-Za-z0-9_\-\s]+$/', 'message'=>'Допустимы только латинские символы, цифры, подчеркивание и тире'),
			array('name', 'length', 'max'=>32),
			array('email, avatar', 'length', 'max'=>128),
			array('email', 'email'),
			array('email, login', 'unique'),
			array('dob, sign', 'safe'),
			//array('dob','date'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('uid, login, pwdhash, name, email, dob, regdata, sign, avatar, role', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'articles' => array(self::HAS_MANY, 'Article', 'author'),
			'cCalendars' => array(self::HAS_MANY, 'CCalendar', 'manager'),
			'comments' => array(self::HAS_MANY, 'Comment', 'author'),
			'federationMembers' => array(self::HAS_MANY, 'FederationMember', 'user'),
			'pwdrestore' => array(self::HAS_ONE, 'Pwdrestore', 'uid'),
			'tags' => array(self::HAS_MANY, 'Tags', 'user'),
			'mail' => array(self::HAS_MANY, 'Mail', 'user'),
			);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'uid' => 'user unique id',
			'login' => 'login',
			'pwdhash' => 'hash of passowrd',
			'name' => 'Имя пользователя',
			'email' => 'E-Mail',
			'dob' => 'Дата рождения',
// 			'regdata' => 'Дата регистрации',
			'regdate' => 'Дата регистрации',
			'sign' => 'Подпись',
			'role' => 'Роль пользователя',
			'avatar' => 'Аватар пользователя',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('uid',$this->uid);
		$criteria->compare('login',$this->login,true);
		$criteria->compare('pwdhash',$this->pwdhash,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('dob',$this->dob,true);
		$criteria->compare('regdata',$this->regdata,true);
		$criteria->compare('sign',$this->sign,true);
		$criteria->compare('avatar',$this->avatar,true);
		$criteria->compare('role',$this->role,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	
	protected function afterFind()
	{
	    $this->toView();
	    parent::afterFind();
	}
	
	
	protected function beforeSave()
	{
	    if ($this->isNewRecord) {
		if (count(User::model()->findAll()) === 0) {
		    $this->role= crypt($this->login);
		} else {
		    $this->role= crypt($this->regdata);
		}
	    }
	    
	    if ($this->dob !='') {
		$dob = explode('.',$this->dob);
		if(isset($dob[2])) $this->dob = "{$dob[2]}-{$dob[1]}-{$dob[0]}";
		else unset($this->dob);
	    } else unset($this->dob);

	    $ret = parent::beforeSave();
	    return $ret;
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/** @brief Set administration rights to current user (model)
	 * @param bool $isAdmin is administration rights value.
	 * @return true is successed, else false */
	public function setAdmin($isAdmin) 
	{
	    if ($isAdmin === true) {
		$this->role= crypt($this->login);
	    } else {
		$this->role= crypt($this->regdata);
	    }
	    return $this->save();
	}
	
	public function isAdmin()
	{
	    return ($this->role === crypt($this->login, $this->role));
	}
	
	protected function toView()
	{
	    if ($this->dob !='') {
		$dob = explode('-',$this->dob);
		if(isset($dob[2])) $this->dob = "{$dob[2]}.{$dob[1]}.{$dob[0]}";
	    }
	    $regdate = explode(" ", $this->regdata);
	    $date = explode('-', $regdate[0]);
	    $this->regdate = "{$date[2]}.{$date[1]}.{$date[0]} в {$regdate[1]}";
	}
	
	
	protected function afterSave()
	{
	    $this->toView();
	    parent::afterSave();
	}
	
}
