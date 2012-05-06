<?php $this->pageTitle=Yii::app()->name . ' - Home';
$this->breadcrumbs=array(
	'Home',
);
?>
<h1>Welcome</h1>
<p><strong class="txt1">Lorem ipsum</strong> 
    In hac habitasse platea dictumst. Mauris rhoncus justo a tortor tincidunt volutpat. In hac habitasse platea dictumst. Praesent volutpat commodo metus in faucibus. Donec vel risus sit amet lorem lacinia vestibulum vitae in eros. In hac habitasse platea dictumst. Integer pharetra volutpat turpis, ac scelerisque arcu imperdiet ac. Praesent sed mi dui, tincidunt interdum quam.
</p>
<h1>Latest Products</h1>
<?php $this->breadcrumbs=array(
	'Products'=>array('/products/index'),
        'Latest products'
);?>
<?php
if ($dataSet->getTotalItemCount() == 0) {
    echo 'Sorry, currently there are no products available.';
} else {
    Yii::app()->clientScript->registerCssFile(Yii::app()->getBaseUrl() . '/css/product.css');
    $this->widget('zii.widgets.CListView', array(
        'dataProvider' => $dataSet,
        'itemView' => '../products/_item',
        'sortableAttributes' => array(),
        'pager' => array(
            'class' => 'SeoLinkPager',
            'cssFile' => Yii::app()->baseUrl.'/css/'.'pager.css',
            )
        ));
}
Yii::app()->getClientScript()->registerScriptFile('/js/preview.js');
?>