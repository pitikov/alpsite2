<?php

/**
 * This is the model class for table "federation_member".
 *
 * The followings are the available columns in table 'federation_member':
 * @property integer $id
 * @property integer $user
 * @property string $name
 * @property string $dob
 * @property string $photo
 * @property string $description
 * @property integer $role
 * @property string $memberfrom
 * @property string $memberto
 *
 * The followings are the available model relations:
 * @property FederationRole $roles
 * @property MountaringMembers[] $mountaringMembers
 * @property User $users
 */
class FederationMember extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'federation_member';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('user, role', 'numerical', 'integerOnly'=>true),
			array('name, photo', 'length', 'max'=>128),
			array('dob, description, memberfrom, membert', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user, name, dob, photo, description, role', 'safe', 'on'=>'search'),
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
			'roles' => array(self::BELONGS_TO, 'FederationRole', 'role'),
			'users' => array(self::BELONGS_TO, 'User', 'user'),
			'mountaringMembers' => array(self::HAS_MANY, 'MountaringMembers', 'member'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user' => 'uid',
			'name' => 'Фамилия Имя Отчество',
			'dob' => 'родился(ась)',
			'photo' => 'фото',
			'description' => 'текст',
			'role' => 'занимаемая должность',
			'memberfrom' => 'член федерации с',
			'memberto' => 'член федерации по',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('dob',$this->dob,true);
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('role',$this->role);
		$criteria->compare('memberfrom',$this->memberfrom,true);
		$criteria->compare('memberto',$this->memberto,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FederationMember the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}