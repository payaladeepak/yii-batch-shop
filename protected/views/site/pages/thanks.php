<?php
$this->pageTitle=Yii::app()->name . ' - Thanks !';
$this->breadcrumbs=array(
	'Thanks',
);
?>

<h1>Thanks for your purchase</h1>
<p>
    Your order has been confirmed, please look to your inbox for an email receipts and further informations about your purchase.<br/>
    We will give you a link to be able to track your package as soon as possible.<br/>
    If not, please email <?php echo Yii::app()->params['adminEmail'];?> and we will resend).
</p>