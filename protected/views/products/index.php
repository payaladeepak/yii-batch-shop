<?php Yii::app()->getClientScript()->registerMetaTag(Yii::app()->params['metaDescription'].' - Home','description',null,array('lang' => Yii::app()->params['metaLang']));?>
<?php $this->renderPartial('_scripts');?>
<h1>Random Products</h1>
<?php $this->breadcrumbs=array(
	'Products'=>array('/products/index'),
        '50 Random products'
);?>
<?php
if ($dataSet->getTotalItemCount() == 0) {
    echo 'Sorry, currently there are no products available in this category.';
} else {
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/product.css');
    $this->widget('zii.widgets.CListView', array(
        'dataProvider' => $dataSet,
        'itemView' => '_item',
        'sortableAttributes' => array(),
        'pager' => array(
            'class' => 'SeoLinkPager',
            'cssFile' => Yii::app()->baseUrl.'/css/'.'pager.css',
            )
        ));
}
?>