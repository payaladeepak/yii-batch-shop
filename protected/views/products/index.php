<?php Yii::app()->getClientScript()->registerMetaTag(Yii::app()->params['metaDescription'].' - Home','description',null,array('lang' => Yii::app()->params['metaLang']));?>
<?php Yii::app()->getClientScript()->registerScriptFile('/js/imgpreview.min.0.22.jquery.js');?>
<?php Yii::app()->getClientScript()->registerScript('preview',
        '$(document).ready(function() {
            var w = screen.width/3;
            var xOffset = -screen.width/2.9
            var yOffset = -200;
            $(\'.preview\').imgPreview({
            srcAttr: \'rel\',
            distanceFromCursor: { top: yOffset, left: xOffset },
            imgCSS: { width: w }
        });
        });');?>
<h1>Random Products</h1>
<?php $this->breadcrumbs=array(
	'Products'=>array('/products/index'),
        '50 Random products'
);?>
<?php
if ($dataSet->getTotalItemCount() == 0) {
    echo 'Sorry, currently there are no products available in this category.';
} else {
    Yii::app()->clientScript->registerCssFile(Yii::app()->getBaseUrl() . '/css/product.css');
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