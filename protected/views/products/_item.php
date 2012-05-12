<div class="product">
    <a rel="<?php echo $data->image_url; ?>" class="preview" href="<?php echo Yii::app()->urlManager->createUrl('products/details',array('id'=>$data->id,'c'=>$data));?>">
        <img alt="<?php echo $data->title; ?>" src="<?php echo $data->thumb_url; ?>">
    </a>
    <p><?php echo $data->title; ?><br/><span><?php echo $data->price; ?><?php echo Yii::app()->params['currencySymbol'];?></span></p>
</div>