<?php

/**
 * This is the model class for table "comment".
 *
 * The followings are the available columns in table 'comment':
 * @property integer $cid
 * @property integer $article
 * @property integer $parent
 * @property integer $author
 * @property string $dop
 * @property string $title
 * @property string $body
 * @property integer $rating
 *
 * The followings are the available model relations:
 * @property Article $article0
 * @property User $author0
 * @property Comment $parent0
 * @property Comment[] $comments
 */
class Comment extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'comment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('article, author, dop, title, body', 'required'),
			array('article, parent, author, rating', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>254),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('cid, article, parent, author, dop, title, body, rating', 'safe', 'on'=>'search'),
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
			'author0' => array(self::BELONGS_TO, 'User', 'author'),
			'parent0' => array(self::BELONGS_TO, 'Comment', 'parent'),
			'comments' => array(self::HAS_MANY, 'Comment', 'parent'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cid' => 'unique article id',
			'article' => 'статья',
			'parent' => '...на комментарий',
			'author' => 'автор',
			'dop' => 'опубликованно',
			'title' => 'заголовок',
			'body' => 'текст',
			'rating' => 'рейтинг',
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

		$criteria->compare('cid',$this->cid);
		$criteria->compare('article',$this->article);
		$criteria->compare('parent',$this->parent);
		$criteria->compare('author',$this->author);
		$criteria->compare('dop',$this->dop,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('body',$this->body,true);
		$criteria->compare('rating',$this->rating);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Comment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
