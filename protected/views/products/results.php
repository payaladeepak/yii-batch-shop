<?php $this->pageTitle=Yii::app()->name.' - Search result(s)';?>
<?php Yii::app()->getClientScript()->registerMetaTag(Yii::app()->params['metaDescription'].' - Search result(s)','description',null,array('lang' => Yii::app()->params['metaLang']));?>
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
        });');
$this->breadcrumbs=array(
    'Search result(s)',
);
?>

<h1>Search result(s)</h1>

<?php
if($dataSet->getTotalItemCount()==0) {
    echo 'No results found.';
}
else {
    Yii::app()->clientScript->registerCssFile(Yii::app()->getBaseUrl().'/css/product.css');
    $this->widget('zii.widgets.CListView',array(
        'dataProvider'=>$dataSet,
        'itemView'=>'_item',
        'sortableAttributes'=>array(
            'price'=>'Price',
            'title'=>'Product model',
    ),'pager'=>array(
        'class'=>'SeoLinkPager',
        'cssFile'=>Yii::app()->baseUrl.'/css/'.'pager.css',
    )));
}
?>