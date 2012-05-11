<?php $this->pageTitle=Yii::app()->name . ' - Viewing : '.$this->model->title;?>
<?php Yii::app()->getClientScript()->registerMetaTag(Yii::app()->params['metaDescription'].' - Viewing : '.$this->model->title,'description',null,array('lang' => Yii::app()->params['metaLang']));?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/js/fancybox/jquery.fancybox.css?v=2.0.6','screen');?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/js/fancybox/helpers/jquery.fancybox-thumbs.css?v=2.0.6','screen');?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/js/fancybox/jquery.fancybox.pack.js?v=2.0.6');?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/js/fancybox/helpers/jquery.fancybox-thumbs.js?v=2.0.6');?>
<?php Yii::app()->getClientScript()->registerScript('fancybox',
'$(document).ready(function () {
    $(".fancybox-thumb").fancybox({
        prevEffect: \'none\',
        nextEffect: \'none\',
        helpers: {
            title: {
                type: \'outside\'
            },
            overlay: {
                opacity: 0.8,
                css: {
                    \'background-color\': \'#000\'
                }
            },
            thumbs: {
                width: 50,
                height: 50
            }
        }
});});'
        );?>
<h1>Product : <?php echo $this->model->title; ?></h1>
<table width="100%">
    <tbody>
        <tr>
            <td colspan="2" align="center">
                <?php echo CHtml::link(CHtml::image($this->model->image_url,$this->model->title,array('style'=>'max-width:'.Yii::app()->params['maxWidth'].'px;')), $this->model->image_url, array('title' => $this->model->title, 'class' => 'fancybox-thumb', 'rel' => 'fancybox-thumb')); ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <p>Click on the image above to enlarge it.</p>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                <p style="color:#D60C0C;font-weight:bold;">Price&nbsp;:&nbsp;<?php echo $this->model->price . Yii::app()->params['currencySymbol'];?></p>
            </td>
            <td>
                <form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                    <input type="hidden" name="business" value="<?php echo Yii::app()->params['adminEmail'];?>">
                    <input type="hidden" name="cmd" value="_cart">
                    <input type="hidden" name="add" value="1">
                    <?php if ($options[0]!=false): ?>
                    <p>
                        <input type="hidden" name="on0" value="Option">Option(s)&nbsp;:
                        <select name="os0">
                            <?php foreach ($options as $key => $value): ?>
                                <option value="<?php echo $value; ?>" id="<?php echo $key; ?>" name="<?php echo $key; ?>"><?php echo $value; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </p>
                    <?php endif; ?>
                    <p>
                        Choose quantity&nbsp;:
                        <input type="text" name="quantity" value="1" size="4" maxlength="4">
                    </p>
                    <input type="hidden" name="item_name" value="<?php echo $itemCat.' - '.$this->model->title;?>">
                    <input type="hidden" name="amount" value="<?php echo $this->model->price;?>">
                    <input type="hidden" name="currency_code" value="<?php echo Yii::app()->params['currencyCode'];?>">
                    <input type="hidden" name="shopping_url" value="<?php echo $this->createAbsoluteUrl($this->route,$_GET);?>">
                    <p>
                        <input type="image" name="submit" border="0" src="https://www.paypal.com/en_US/i/btn/btn_cart_LG.gif" alt="PayPal - The safer, easier way to pay online">
                    </p>
                    <img alt="" border="0" width="1" height="1" src="https://www.paypal.com/en_US/i/scr/pixel.gif" >
                </form>
            </td>
        </tr>
    </tbody>
</table>
<h4>Feedbacks</h4>
<?php
$this->widget('CTabView', array(
    'cssFile'=>'/css/tabs.css',
    'activeTab'=>(Yii::app()->request->isPostRequest?'tab2':'tab1'),
    'tabs' => array(
        'tab1' => array(
            'title' => 'View feedbacks',
            'view' => 'feedbacks/_list',
            'data' => array('dataProvider' => $dataProvider),
        ),
        'tab2' => array(
            'title' => 'Post a feedback',
            'view' => 'feedbacks/_form',
            'data' => array('feedbacks' => $feedbacks),
        ),
    )
));
?>
