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
 * @property integer $trash
 *
 * The followings are the available model relations:
 * @property User $user0
 * @property User $sender0
 * @property User $receiver0
 */
class Mail extends CActiveRecord
{
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
			array('user, sender, receiver, subject, body, sended, folder', 'required'),
			array('user, sender, receiver, trash', 'numerical', 'integerOnly'=>true),
			array('subject', 'length', 'max'=>128),
			array('folder', 'length', 'max'=>6),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user, sender, receiver, subject, body, sended, folder, trash', 'safe', 'on'=>'search'),
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
			'user0' => array(self::BELONGS_TO, 'User', 'user'),
			'sender0' => array(self::BELONGS_TO, 'User', 'sender'),
			'receiver0' => array(self::BELONGS_TO, 'User', 'receiver'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user' => 'User',
			'sender' => 'Sender',
			'receiver' => 'Receiver',
			'subject' => 'Subject',
			'body' => 'Body',
			'sended' => 'Sended',
			'folder' => 'Folder',
			'trash' => 'Trash',
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
}
