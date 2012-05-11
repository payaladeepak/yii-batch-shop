<?php $this->pageTitle=Yii::app()->name.' - Viewing : '.$this->model->title;?>
<?php Yii::app()->getClientScript()->registerMetaTag(Yii::app()->params['metaDescription'].' - Viewing : '.$this->model->title,'description',null,array('lang'=>Yii::app()->params['metaLang']));?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/js/fancybox/jquery.fancybox.css?v=2.0.6','screen');?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/js/fancybox/helpers/jquery.fancybox-thumbs.css?v=2.0.6','screen');?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/js/fancybox/jquery.fancybox.pack.js?v=2.0.6');?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/js/fancybox/helpers/jquery.fancybox-thumbs.js?v=2.0.6');?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.locale.js');?>
<?php Yii::app()->getClientScript()->registerScript('fancybox','$(document).ready(function () {
    $(".fancybox-thumb").fancybox({
        prevEffect: \'none\',
        nextEffect: \'none\',
        helpers: {
            title: {
                type: \'outside\'
            },
            overlay: {
                opacity: 0.8,
                css: {
                    \'background-color\': \'#000\'
                }
            },
            thumbs: {
                width: 50,
                height: 50
            }
        }
});});');?>
<?php Yii::app()->getClientScript()->registerScript('countries','$(document).ready(function () {$(\'#countries\').locale();});');?>
<?php
$this->widget('CTabView',array(
    'cssFile'=>'/css/tabs.css',
    'activeTab'=>(Yii::app()->request->isPostRequest?'tab3':'tab1'),
    'tabs'=>array(
        'tab1'=>array(
            'title'=>'Product details',
            'view'=>'_product',
            'data'=>array(
                'options'=>$options,
                'itemCat'=>$itemCat,
            ),
        ),
        'tab2'=>array(
            'title'=>'View feedbacks',
            'view'=>'feedbacks/_list',
            'data'=>array(
                'dataProvider'=>$dataProvider,
            ),
        ),
        'tab3'=>array(
            'title'=>'Post a feedback',
            'view'=>'feedbacks/_form',
            'data'=>array(
                'feedbacks'=>$feedbacks,
            ),
        ),
)));
?>