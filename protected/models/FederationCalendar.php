<?php

/**
 * This is the model class for table "f_calendar".
 *
 * The followings are the available columns in table 'f_calendar':
 * @property integer $aid
 * @property string $title
 * @property string $begin
 * @property string $finish
 * @property double $location_lat
 * @property double $location_lng
 * @property integer $article
 *
 * The followings are the available model relations:
 * @property Article $article0
 */
class FederationCalendar extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'f_calendar';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, begin, finish, article', 'required'),
			array('article', 'numerical', 'integerOnly'=>true),
			array('location_lat, location_lng', 'numerical'),
			array('title', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('aid, title, begin, finish, location_lat, location_lng, article', 'safe', 'on'=>'search'),
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
			'article0' => array(self::BELONGS_TO, 'Article', 'article'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'aid' => 'unique number of mountaring actions',
			'title' => 'title of action',
			'begin' => 'date of begin mountaring action',
			'finish' => 'date of finish mountaring action',
			'location_lat' => 'position from latitude',
			'location_lng' => 'position from logitude',
			'article' => 'Description of mountaring action',
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

		$criteria->compare('aid',$this->aid);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('begin',$this->begin,true);
		$criteria->compare('finish',$this->finish,true);
		$criteria->compare('location_lat',$this->location_lat);
		$criteria->compare('location_lng',$this->location_lng);
		$criteria->compare('article',$this->article);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FederationCalendar the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
