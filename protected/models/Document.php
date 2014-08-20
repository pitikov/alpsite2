<?php

/**
 * This is the model class for table "document".
 *
 * The followings are the available columns in table 'document':
 * @property string $document
 * @property integer $owner
 * @property string $description
 * @property integer $private
 * @property string $type
 * @property string $file_name
 *
 * The followings are the available model relations:
 * @property User $documentOwner
 */
class Document extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'document';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('owner, description', 'required'),
			array('owner, private', 'numerical', 'integerOnly'=>true),
			array('document', 'file', 'types'=>'jpg, gif, png', 'on'=>'image'),
			array('document, file_name', 'length', 'max'=>128),
			array('type', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('document, owner, description, private, type, file_name', 'safe', 'on'=>'search'),
			array('file_name', 'unique'),
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
			'documentOwner' => array(self::BELONGS_TO, 'User', 'owner'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'document' => 'путь',
			'owner' => 'загрузил',
			'description' => 'описание',
			'private' => 'личный',
			'type' => 'тип',
			'file_name' => 'имя файла',
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

		$criteria->compare('document',$this->document,true);
		$criteria->compare('owner',$this->owner);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('private',$this->private);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('file_name',$this->file_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Document the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
