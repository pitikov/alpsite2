<?php

/**
 * This is the model class for table "mountaring".
 *
 * The followings are the available columns in table 'mountaring':
 * @property integer $id
 * @property string $date
 * @property integer $route
 * @property string $description
 *
 * The followings are the available model relations:
 * @property Route $mountaringRoute
 * @property MountaringMembers[] $mountaringMembers
 *
 * The calculated values
 * @property string $Leader
 * @property string $Composition
 */
class Mountaring extends CActiveRecord
{
	/// @brief Руководитель восхождения
	public $Leader;
	
	/// @brief Состав
	public $Composition;
		
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mountaring';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, route', 'required'),
			array('route', 'numerical', 'integerOnly'=>true),
			array('description', 'safe'),
			array('route','existed'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, date, route, description', 'safe', 'on'=>'search'),
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
			'mountaringRoute' => array(self::BELONGS_TO, 'Route', 'route'),
			'mountaringMembers' => array(self::HAS_MANY, 'MountaringMembers', 'mountaring'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '№',
			'date' => 'дата',
			'route' => 'по маршруту',
			'description' => 'Описание',
			'Leader'=>'Руководитель',
			'Composition'=>'в составе',
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
		$criteria->compare('date',$this->date,true);
		$criteria->compare('route',$this->route);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Mountaring the static model class
	 */
	public static function model($className=__CLASS__)
	{
	    return parent::model($className);
	}
	
	public function existed($attribute, $params)
	{
	    $route = Route::model()->findByPk($this->route);
	    if ($route===null) {
		$this->addError($attribute, "Указанный маршрут отсутствует в базе данных");
	    }
	}
	
	public function afterFind()
	{
// 	    $this->Peak = $mountaringRoute->
// 	    
// 	    $leader = MountaringMember::model()->find('mountaring=:Mountaring, role=:Role', array(':Mountaring'=>$this->id, ':Role'=>'руководитель'));
// 	    if (isset($leader)) {
// 		if ($leader->member !== null) {
// 		    $this->Leader = $leader->member0->name;
// 		} else {
// 		    $this->Leader = $leader->name;
// 		}
// 	    }
	    
	    return parent::aftrFind();
	}
}
