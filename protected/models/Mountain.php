<?php

/**
 * This is the model class for table "mountain".
 *
 * The followings are the available columns in table 'mountain':
 * @property integer $id
 * @property integer $region
 * @property string $title
 * @property double $location_lat
 * @property double $location_lng
 * @property string $description
 *
 * The followings are the available model relations:
 * @property Region $region0
 * @property Route[] $routes
 */
class Mountain extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mountain';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('region, title', 'required'),
			array('region', 'numerical', 'integerOnly'=>true),
			array('location_lat, location_lng', 'numerical'),
			array('title', 'length', 'max'=>128),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, region, title, location_lat, location_lng, description', 'safe', 'on'=>'search'),
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
			'region0' => array(self::BELONGS_TO, 'Region', 'region'),
			'routes' => array(self::HAS_MANY, 'Route', 'mountain'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'region' => 'Region',
			'title' => 'mountain title',
			'location_lat' => 'position from latitude',
			'location_lng' => 'position from logitude',
			'description' => 'Description',
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
		$criteria->compare('region',$this->region);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('location_lat',$this->location_lat);
		$criteria->compare('location_lng',$this->location_lng);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Mountain the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
