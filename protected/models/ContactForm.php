<?php
class ContactForm extends CFormModel
{
    public $email;
    public $subject;
    public $body;
    public $verifyCode;
    public function rules()
    {
        return array(
            array('email,subject,body','required'),
            array('email','email'),
            array('verifyCode','captcha','allowEmpty'=>!CCaptcha::checkRequirements())
        );
    }
    public function attributeLabels()
    {
        return array(
            'verifyCode'=>'Verification Code'
        );
    }
}