<?php
$this->breadcrumbs=array(
	'Foobars'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Foobar', 'url'=>array('index')),
	array('label'=>'Manage Foobar', 'url'=>array('admin')),
);
?>

<h1>Create Foobar</h1>
    <?php $this->widget('CTabView',array(
    'tabs'=>array(
        'tab1'=>array(
            'title'=>'tab1',
            'view'=>'_form',
            'data'=>array(
                'model'=>$model,
            ),
        ),
        'tab2'=>array(
            'title'=>'tab2',
            'view'=>'_form2',
            'data'=>array(
                'model'=>$model,
            ),
        ),
))); ?>
<?php //echo $this->renderPartial('_form', array('model'=>$model)); ?>