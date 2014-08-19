<?php

/**
 * This is the model class for table "federation_role".
 *
 * The followings are the available columns in table 'federation_role':
 * @property integer $id
 * @property string $title
 * @property integer $position
 *
 * The followings are the available model relations:
 * @property FederationMember[] $federationMembers
 */
class FederationRole extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'federation_role';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, position', 'required'),
			array('position', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>128),
			array('title, position', 'unique'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, position', 'safe', 'on'=>'search'),
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
			'federationMembers' => array(self::HAS_MANY, 'FederationMember', 'role'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '№',
			'title' => 'Должность',
			'position' => 'порядок',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('position',$this->position);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FederationRole the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	
	protected function beforeValidate()
	{
	    if ($this->isNewRecord) {
		$maxValue = $this->model()->find(array(
		    'select'=>'position',
		    'order'=>'position desc',
		));
		if (isset($maxValue)) {
		    $this->position = $maxValue->position+1;
		} else {
		    $this->position = 1;
		}		
	    }
	    $ret = parent::beforeValidate();
	    return $ret;
	}
	
	
}
