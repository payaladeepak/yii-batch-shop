<?php
class SiteController extends Controller
{
    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xF7F7F7
            ),
            'page' => array(
                'class' => 'CViewAction'
            )
        );
    }
    public function init() {
        Yii::app()->clientScript->registerCssFile(Yii::app()->getBaseUrl().'/css/menu.css');
        $this->registerAssets();
    }
    public function actionIndex() {
        $dataSet=new CActiveDataProvider('Products',array('criteria'=>array(
                        'order'=>'date_added',
                    ),'pagination'=>array(
                        'pageSize'=>40,
                    )
                ));
        $this->render('index',array('dataSet'=>$dataSet));
    }
    public function actionError()
    {
        $error = Yii::app()->errorHandler->error;
        if ($error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                Yii::app()->mailer->AddAddress(Yii::app()->params['adminEmail']);
                Yii::app()->mailer->From = $model->email;
                Yii::app()->mailer->Subject = $model->subject;
                Yii::app()->mailer->MsgHTML($model->body);
                Yii::app()->mailer->Send();
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array(
            'model' => $model
        ));
    }
    public function actionLogin()
    {
        $model = new LoginForm;
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        $this->render('login', array(
            'model' => $model
        ));
    }
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }
}