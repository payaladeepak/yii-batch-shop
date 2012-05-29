<?php
$this->breadcrumbs=array(
	'Manage Products',
);

$this->menu=array(
	array('label'=>'Back', 'url'=>array('/site/index')),
	array('label'=>'List Products', 'url'=>array('admin')),
	array('label'=>'Create Products', 'url'=>array('add')),
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('products-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Products</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search'); ?>
</div><!-- search-form -->
<?php
echo CHtml::beginForm('BatchDelete');
echo CHtml::button('Delete selected',array('onclick'=>'this.form.submit();'));
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'products-grid',
	'dataProvider'=>$this->model->search(),
	'filter'=>$this->model,
	'columns'=>array(
            array(
                'class'=>'CCheckBoxColumn',
                'id'=>'id',
                'selectableRows'=>2,
            ),
		'title',
		'price',
		'thumb_url'=>
            array(
                'name'=>'thumb_url',
                'type'=>'image',                
                ),
                'date_added'=>
            array(
                'name'=>'date_added',
                'type'=>'datetime',
            ),
            array(
                'name'=>'related_menu',
                'value'=>'$data->menu->name',
                ),
            array(
		'class'=>'CButtonColumn',
                'template'=>'{update}{delete}'
		),
	),
));
echo CHtml::endForm();
?>