<?php

/**
 * This is the model class for table "mail".
 *
 * The followings are the available columns in table 'mail':
 * @property integer $id
 * @property integer $user
 * @property integer $sender
 * @property integer $receiver
 * @property string $subject
 * @property string $body
 * @property string $sended
 * @property string $folder
 * @property boolean $trash
 * @property boolean $unread
 *
 * The local propertys:
 * @property boolean $check;
 *
 * The followings are the available model relations:
 * @property User $User
 * @property User $Sender
 * @property User $Receiver
 */
class Mail extends CActiveRecord
{
	/// Поиск получателя по совпадению с Email, login, или имя пользователя
	public $receiversearch;
	
	public $check = false;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user, sender, subject, body, folder', 'required'),
			array('receiversearch', 'find', 'on'=>'sendmail'),
			array('receiver','existed'),
			array('user, sender, receiver', 'numerical', 'integerOnly'=>true),
			array('subject', 'length', 'max'=>128),
			array('folder', 'length', 'max'=>6),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user, sender, receiver, subject, body, sended, folder, trash, unread', 'safe', 'on'=>'search'),
			array('check, unread, trash', 'boolean'),
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
			'User' => array(self::BELONGS_TO, 'User', 'user'),
			'Sender' => array(self::BELONGS_TO, 'User', 'sender'),
			'Receiver' => array(self::BELONGS_TO, 'User', 'receiver'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user' => 'владелец',
			'sender' => 'отправитель',
			'receiver' => 'получатель',
			'receiversearch' => 'получатель',
			'subject' => 'тема',
			'body' => 'текст',
			'sended' => 'отпрвленно',
			'folder' => 'папка',
			'trash' => 'удаленно',
			'check' => 'выделение',
			'unread' => 'не прочитанно',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('user',$this->user);
		$criteria->compare('sender',$this->sender);
		$criteria->compare('receiver',$this->receiver);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('body',$this->body,true);
		$criteria->compare('sended',$this->sended,true);
		$criteria->compare('folder',$this->folder,true);
		$criteria->compare('trash',$this->trash);
		$criteria->compare('unrea',$this->unread);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Mail the static model class
	 */
	public static function model($className=__CLASS__)
	{
	    return parent::model($className);
	}
	
	/** Проверка на наличие записи в БД */
	public function existed($attribute, $params)
	{
	    $receiver = User::model()->findByPk($this->receiver);
	    $label = $this->getAttributeLabel($attribute);
	    if ($receiver===null) $this->addError('receiversearch', "{$label} отсутствует в базе данных");
	}
	
	public function find($attribute, $params)
	{
	    /// @todo выделить email из строки пользователя
	    $find = 'pitikov@yandex.ru';
	    $receiver = User::model()->find('email = :Search', array(':Search'=>$find));
	    $label = $this->getAttributeLabel($attribute);
	    if ($receiver===null) {
		//$this->addError('receiversearch', "{$label} отсутствует в базе данных");
	    } else {
		$this->receiver = $receiver->uid;
	    }
	}
}
