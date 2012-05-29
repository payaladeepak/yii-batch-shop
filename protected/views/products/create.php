<?php
$this->breadcrumbs = array(
    'Products' => array('index'),
    'Create',
);

$this->menu=array(
	array('label'=>'Back', 'url'=>array('/site/index')),
	array('label'=>'List Products', 'url'=>array('admin')),
	array('label'=>'Create Products', 'url'=>array('add')),
);
?>

<h1>Create Products</h1>
<?php if (empty($listData)): ?>
    <div style="color:red;"><p>Please create a menu category first</p></div>
<?php else: ?>
    <?php $this->widget('CTabView',array(
    'cssFile'=>'/css/tabs.css',
    'activeTab'=>(Yii::app()->request->isPostRequest&&$_POST['activeTab']=='batch-form'?'tab2':'tab1'),
    'tabs'=>array(
        'tab1'=>array(
            'title'=>'Add a product',
            'view'=>'_form',
            'data'=>array(
                'listData'=>$listData,
            ),
        ),
        'tab2'=>array(
            'title'=>'Batch additions',
            'view'=>'_batch-form',
            'data'=>array(
                'listData'=>$listData,
            ),
        ),
))); ?>
<?php endif; ?>