<?php
$this->breadcrumbs=array(
	'Foobars',
);

$this->menu=array(
	array('label'=>'Create Foobar', 'url'=>array('create')),
	array('label'=>'Manage Foobar', 'url'=>array('admin')),
);
?>

<h1>Foobars</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
