<?php
$this->breadcrumbs = array(
    'Products' => array('index'),
    'Create',
);

$this->menu=array(
	array('label'=>'Back', 'url'=>array('/site/index')),
	array('label'=>'List Products', 'url'=>array('admin')),
	array('label'=>'Create Products', 'url'=>array('create')),
);
?>

<h1>Batch Create Products</h1>
<?php if (empty($listData)): ?>
    <div style="color:red;"><p>Please create a menu category first</p></div>
<?php else: ?>
    <?php echo $this->renderPartial('_form', array('listData' => $listData)); ?>
<?php endif; ?>