<?php $this->pageTitle=Yii::app()->name . ' - Viewing products in '.end($this->breadcrumbs);?>
<?php Yii::app()->getClientScript()->registerMetaTag(Yii::app()->params['metaDescription'].' - Viewing products in '.end($this->breadcrumbs),'description',null,array('lang' => Yii::app()->params['metaLang']));?>
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
<h1>Viewing <?php echo $title;?></h1>
<?php
if ($dataSet->getTotalItemCount() == 0) {
    echo 'Sorry, currently there are no products available in this category.';
} else {
    Yii::app()->clientScript->registerCssFile(Yii::app()->getBaseUrl() . '/css/product.css');
    $this->widget('zii.widgets.CListView', array(
        'dataProvider' => $dataSet,
        'itemView' => '_item',
        'sortableAttributes' => array(
            'price' => 'Price',
            'title' => 'Product model',
            ),
        'pager' => array(
            'class' => 'SeoLinkPager',
            'cssFile' => Yii::app()->baseUrl.'/css/'.'pager.css',
            )
        ));
}
?>