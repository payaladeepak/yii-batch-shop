<?php $this->pageTitle=Yii::app()->name . ' - Viewing : '.$this->model->title;?>
<?php Yii::app()->getClientScript()->registerMetaTag(Yii::app()->params['metaDescription'].' - Viewing : '.$this->model->title,'description',null,array('lang' => Yii::app()->params['metaLang']));?>
<h1>Product : <?php echo $this->model->title; ?></h1>
<table>
    <tbody>
        <tr>
            <td style="padding-right:20px;">
                <?php $this->widget('ext.lyiightbox.LyiightBox2', array(
                    'thumbnail' => $this->model->thumb_url,
                    'image' => $this->model->image_url,
                    'title' => $this->model->title,
                    ));
                ?>
            </td>
            <td align="left" width="80%" style="vertical-align: top;">
                <p style="color:#D60C0C;font-weight:bold;">Price&nbsp;:&nbsp;<?php echo $this->model->price . Yii::app()->params['currencySymbol'];?></p>
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
                        <input type="text" name="quantity" value="1">
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
<br/>
<h5>Click on the image above to enlarge it.</h5>