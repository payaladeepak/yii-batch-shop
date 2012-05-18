<?php
$this->breadcrumbs=array(
	'Foobars'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Foobar', 'url'=>array('index')),
	array('label'=>'Create Foobar', 'url'=>array('create')),
	array('label'=>'View Foobar', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Foobar', 'url'=>array('admin')),
);
?>

<h1>Update Foobar <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>