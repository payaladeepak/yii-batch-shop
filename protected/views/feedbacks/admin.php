<?php
$this->breadcrumbs=array(
	'Feedbacks'=>array('admin'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('feedbacks-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Feedbacks</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView',array(
    'id'=>'feedbacks-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'content',
        'country',
        'nickname',
        'rating',
        array(
            'class'=>'JToggleColumn',
            'name'=>'approved',
            'filter'=>array('0'=>'No','1'=>'Yes'),
        ),
        array(
            'class'=>'CButtonColumn',
            'buttons'=>array(
                'productPage'=>array(
                    'label'=>'Go to product page',// text label of the button
                    'url'=>$this->createUrl('products/details',array('id'=>'')),// a PHP expression for generating the URL of the button
                    'imageUrl'=>'...',// image URL of the button. If not set or false, a text link is used
                    'options'=>array(),// HTML options for the button tag
                    'click'=>'...',// a JS function to be invoked when the button is clicked
                    'visible'=>'...',// a PHP expression for determining whether the button is visible
                )
            ),
            'template'=>'{productPage}{delete}',
        ),
    ),
));
?>
