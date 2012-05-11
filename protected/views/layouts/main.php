<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
<link href="<?php echo Yii::app()->theme->baseUrl ?>/css/style.css" rel="stylesheet" type="text/css" />
<script src="<?php echo Yii::app()->theme->baseUrl ?>/js/cufon-yui.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl ?>/js/cufon-replace.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl ?>/js/Myriad_Pro_400.font.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl ?>/js/Myriad_Pro_600.font.js" type="text/javascript"></script>
<!--[if lt IE 7]>
	<link href="ie_style.css" rel="stylesheet" type="text/css" />
<![endif]-->
</head>
<body id="page1">
<!-- header -->
<div id="header">
	<div class="container">
<!-- .logo -->
		<div class="logo">
			<a href="index.html"><img src="<?php echo Yii::app()->theme->baseUrl ?>/images/logo.png" alt="" /></a>
		</div>
<!-- /.logo -->
		<?php echo CHtml::beginForm($this->createUrl('products/search'),'GET',array('id'=>'search-form'));?>
                        <fieldset>
				<?php echo CHtml::textField('Products[search]','',array('class'=>'text')); ?><input type="submit" value="Search" class="submit" />
			</fieldset>
                <?php echo CHtml::endForm();?>
                <form id="view-cart" target="_self" action="https://www.paypal.com/cgi-bin/webscr" method="post">  
                    <input type="hidden" name="business" value="<?php echo Yii::app()->params['adminEmail'];?>">  
                    <input type="hidden" name="cmd" value="_cart">  
                    <input type="hidden" name="display" value="1">  
                    <input type="image" name="submit" src="https://www.paypal.com/en_US/i/btn/btn_viewcart_LG.gif" alt="PayPal - The safer, easier way to pay online">  
                    <img alt="" border="0" width="1" height="1" src="https://www.paypal.com/en_US/i/scr/pixel.gif" >
                </form>
<!-- .nav -->
<?php
$this->widget('zii.widgets.CMenu', array(
    'htmlOptions' => array('class' => 'nav'),
    'linkLabelWrapper' => 'span',
    'activeCssClass' => 'current',
    'items' => array(
        array('label' => 'Home', 'url' => array('/site/index')),
        array('label' => 'Payment', 'url' => array('/site/page', 'view' => 'payment')),
        array('label' => 'Shipping', 'url' => array('/site/page', 'view' => 'shipping')),
        array('label' => 'About', 'url' => array('/site/page', 'view' => 'about')),
        array('label' => 'Contact', 'url' => array('/site/contact')),
        array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
        array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)
    ),
));
?>
<!-- /.nav -->
        </div>
</div>
<!-- content -->
<div id="content">
    <div class="container">
        <?php if(!empty($this->breadcrumbs)): ?>
            <?php
            $this->widget('zii.widgets.CBreadcrumbs', array(
            'links' => $this->breadcrumbs,
            'homeLink' => CHtml::link('Site',$this->createUrl('site/index')),
            ));
            ?>
        <?php else:?>
            <div class="breadcrumbs">&nbsp;</div>
        <?php endif;?>
<?php echo $content; ?>
    </div>
</div>
<!-- footer -->
<div id="footer">
    <div class="container">
        <a href="#" onclick="javascript:window.open('https://www.paypal.com/us/cgi-bin/webscr?cmd=xpt/cps/popup/OLCWhatIsPayPal-outside','olcwhatispaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=400, height=350');">
            <img src="https://www.paypal.com/en_US/i/bnr/horizontal_solution_PPeCheck.gif" border="0" alt="Solution Graphics">
        </a><br/>
        Copyright &copy; <?php echo date('Y'); ?> by <?php echo CHtml::encode(Yii::app()->name); ?>.<br/>
        All Rights Reserved.<br/>
        <?php echo Yii::powered(); ?>
    </div>
</div>
<script type="text/javascript"> Cufon.now(); </script>
</body>
</html>