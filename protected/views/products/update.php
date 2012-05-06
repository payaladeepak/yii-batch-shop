<?php
$this->breadcrumbs=array(
	Yii::app()->session->get('item'),
	'Update',
);

$this->menu=array(
	array('label'=>'Back', 'url'=>array('/site/index')),
	array('label'=>'List Products', 'url'=>array('admin')),
	array('label'=>'Create Products', 'url'=>array('create')),
);
?>

<h1>Update Product : <?php echo $this->model->title; ?></h1>

<?php echo $this->renderPartial('_form',array('listData'=>$listData)); ?>