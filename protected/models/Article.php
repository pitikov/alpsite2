<?php

/**
 * This is the model class for table "article".
 *
 * The followings are the available columns in table 'article':
 * @property integer $artid
 * @property integer $author
 * @property string $dop
 * @property string $title
 * @property string $body
 * @property string $art_location
 * @property integer $comment_cnt
 * @property integer $rating
 *
 * The followings are the available model relations:
 * @property User $author0
 * @property Comment[] $comments
 */
class Article extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'article';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('author, dop, title, body', 'required'),
			array('author, comment_cnt, rating', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>254),
			array('art_location', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('artid, author, dop, title, body, art_location, comment_cnt, rating', 'safe', 'on'=>'search'),
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
			'author0' => array(self::BELONGS_TO, 'User', 'author'),
			'comments' => array(self::HAS_MANY, 'Comment', 'article'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'artid' => 'unique article id',
			'author' => 'author uid',
			'dop' => 'published date',
			'title' => 'Article title',
			'body' => 'Article body',
			'art_location' => 'Art Location',
			'comment_cnt' => 'Comment Cnt',
			'rating' => 'Rating',
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

		$criteria->compare('artid',$this->artid);
		$criteria->compare('author',$this->author);
		$criteria->compare('dop',$this->dop,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('body',$this->body,true);
		$criteria->compare('art_location',$this->art_location,true);
		$criteria->compare('comment_cnt',$this->comment_cnt);
		$criteria->compare('rating',$this->rating);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Article the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
