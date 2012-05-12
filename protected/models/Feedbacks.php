<?php
class Feedbacks extends CActiveRecord
{
    public $verifyCode,$date_added,$product_id;
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    public function tableName()
    {
        return 'feedbacks';
    }
    public function rules()
    {
        return array(
            array('country,nickname,content','required'),
            array('rating, approved','numerical','integerOnly' => true),
            array('nickname, country','length','max' => 48),
            array('verifyCode','captcha','allowEmpty'=>!CCaptcha::checkRequirements()),
            array('content, country, nickname, rating, approved','safe','on' => 'search')
        );
    }
    public function relations()
    {
        return array('product'=>array(self::BELONGS_TO,'Products','product_id',));
    }
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'content' => 'Comments',
            'country' => 'Country',
            'nickname' => 'Nickname',
            'rating' => 'Rating',
            'approved' => 'Approved',
            'verifyCode'=>'Verification Code',
            'date_added'=>'Added on',
        );
    }
    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('content', $this->content, true);
        $criteria->compare('country', $this->country, true);
        $criteria->compare('nickname', $this->nickname, true);
        $criteria->compare('rating', $this->rating);
        $criteria->compare('approved', $this->approved);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
    }
}