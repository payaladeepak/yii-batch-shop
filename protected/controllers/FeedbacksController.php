<?php
class FeedbacksController extends Controller
{
    public $layout = '//layouts/column2';
    public function init() {
        Yii::app()->clientScript->registerCssFile(Yii::app()->getBaseUrl().'/css/menu.css');
        parent::init();
    }
    public function filters()
    {
        return array('accessControl');
    }
    public function accessRules()
    {
        return array(
            array('allow','actions' => array('index','create'),'users' => array('*')),
            array('allow','users' => array('admin')),
            array('deny','users' => array('*')),
        );
    }
    public function actionCreate()
    {
        $model = new Feedbacks;
        $dataProvider = new CActiveDataProvider('Feedbacks');
        if (isset($_POST['Feedbacks'])) {
            $model->attributes = $_POST['Feedbacks'];
            if ($model->save())
                $this->redirect(array(
                    'view',
                    'id' => $model->id
                ));
        }
        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'model' => $model,
        ));
    }
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            $this->loadModel($id)->delete();
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array(
                    'admin'
                ));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
    public function actionIndex()
    {
        
    }
    public function actionAdmin()
    {
        $model = new Feedbacks('search');
        $model->unsetAttributes();
        if (isset($_GET['Feedbacks']))
            $model->attributes = $_GET['Feedbacks'];
        $this->render('admin', array(
            'model' => $model
        ));
    }
    public function loadModel($id)
    {
        $model = Feedbacks::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'feedbacks-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
