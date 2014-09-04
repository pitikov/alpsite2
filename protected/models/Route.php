<?php

/**
 * This is the model class for table "route".
 *
 * The followings are the available columns in table 'route':
 * @property integer $id
 * @property integer $mountain
 * @property string $title
 * @property string $difficulty
 * @property integer $winter
 * @property string $author 
 * @property date $year
 * @property string $type
 * @property string $description
 *
 * The followings are the available model relations:
 * @property Mountaring[] $mountarings
 * @property Mountain $Mountain
 */
class Route extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'route';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mountain, title', 'required'),
			array('mountain, winter', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>128),
                        array('author', 'length', 'max'=>64),
			array('difficulty', 'length', 'max'=>3),
                        array('year', 'date', 'format'=>'yyyy'),
                        array('type', 'in', 'range'=>  array_keys(self::getOptions())),
			array('description', 'safe'),
			array('mountain','existsed'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, mountain, title, difficulty, winter, description', 'safe', 'on'=>'search'),
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
			'mountarings' => array(self::HAS_MANY, 'Mountaring', 'route'),
			'Mountain' => array(self::BELONGS_TO, 'Mountain', 'mountain'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'mountain' => 'вершина',
			'title' => 'маршрут',
			'difficulty' => 'к.с.',
			'winter' => 'зимний',
			'author' => 'автор',
			'year' => 'год',
                        'type' => 'тип',
			'description' => 'описание',
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
		$criteria->compare('mountain',$this->mountain);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('difficulty',$this->difficulty,true);
		$criteria->compare('winter',$this->winter);
		$criteria->compare('author',$this->author);
		$criteria->compare('year',$this->year);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Route the static model class
	 */
	public static function model($className=__CLASS__)
	{
	    return parent::model($className);
	}
	
	public function existsed($attribute, $params)
	{
	    $mountain = Mountain::model()->findByPk($this->mountain);
	    if ($mountain===null) {
		$label = $this->getAttributeLabel($attribute);
		$this->addError($attribute, "{$label} отсутствует в базе данных");
	    }
	}
     
        public static function getOptions() {
        return array(
            self::TYPE_ROCK=>'Ск',
            self::TYPE_SNOWANDICE=>'ЛС',
            self::TYPE_MIXED=>'К',
        );
    }
}
