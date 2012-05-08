<?php
class Feedbacks extends CActiveRecord
{
    public $verifyCode;
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
            array('content, country, email, status','required'),
            array('rating, status','numerical','integerOnly' => true),
            array('email, country','length','max' => 48),
            array('verifyCode','captcha','allowEmpty'=>!CCaptcha::checkRequirements()),
            array('content, country, email, rating, status','safe','on' => 'search')
        );
    }
    public function relations()
    {
        return array();
    }
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'content' => 'Comments',
            'country' => 'Country',
            'email' => 'Email',
            'rating' => 'Rating',
            'status' => 'Status',
            'verifyCode'=>'Verification Code',
        );
    }
    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('content', $this->content, true);
        $criteria->compare('country', $this->country, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('rating', $this->rating);
        $criteria->compare('status', $this->status);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
    }
}