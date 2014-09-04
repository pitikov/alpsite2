<?php

/**
 * This is the model class for table "mountain".
 *
 * The followings are the available columns in table 'mountain':
 * @property integer $id
 * @property integer $subregion
 * @property string $title
 * @property integer $height Absolute mountain peak height
 * @property double $location_lat
 * @property double $location_lng
 * @property string $description
 *
 * The followings are the available model relations:
 * @property Region $MountaringRegion
 * @property Route[] $Routes
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
			array('subregion, title, height', 'required'),
			array('subregion, height', 'numerical', 'integerOnly'=>true),
			array('location_lat, location_lng', 'numerical'),
			array('title', 'length', 'max'=>128),
			array('description', 'safe'),
			array('subregion','existed'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, subregion, title, location_lat, location_lng, description', 'safe', 'on'=>'search'),
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
			'MountaringRegion' => array(self::BELONGS_TO, 'Subregion', 'region'),
			'Routes' => array(self::HAS_MANY, 'Route', 'mountain'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'subregion' => 'район',
			'title' => 'вершина',
			'location_lat' => 'широта',
			'location_lng' => 'долгота',
			'description' => 'описание',
                        'height' => 'высота',
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
		$criteria->compare('subregion',$this->subregion);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('height',$this->height);
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
	
	public function existed($attribute,$params)
	{
	    $region = Subregion::model()->findByPk($this->region);
	    $label = $this->getAttributeLabel($attribute);
	    if ($region===null) $this->addError('subregion', "{$label} отсутствует в базе данных");
	}
	
}
