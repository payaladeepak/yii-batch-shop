<?php $this->beginContent('//layouts/main'); ?>
<div class="wrapper">
    <div class="aside">
        <!-- .box -->
        <div class="box">
            <?php if (Yii::app()->user->isGuest): ?>
                <h3>Menu</h3>
                <?php $this->actionFetchTree('index'); ?>
                <?php Yii::app()->getClientScript()->registerScript('ie_menu', '$(document).ready(function(){ $("#navmenu-h li,#navmenu-v li").hover( function() { $(this).addClass("iehover"); }, function() { $(this).removeClass("iehover"); } ); });'); ?>
            <?php else: ?>
                <?php if (empty($this->menu)):?>
                    <?php $this->menu=array(
                        array('label'=>'Manage Menus', 'url'=>array('menu/admin')),
                        array('label'=>'Manage Products', 'url'=>array('products/admin')),
                        array('label'=>'Manage Feedbacks', 'url'=>array('feedbacks/admin')),
                    );?>
                <?php endif;?>
                <?php $this->beginWidget('zii.widgets.CPortlet', array('title' => 'Menu')); ?>
                <?php $this->widget('zii.widgets.CMenu', array('items' => $this->menu));?>
                <?php $this->endWidget(); ?>
            <?php endif; ?>
        </div>
        <!-- /.box -->
    </div>
    <div class="mainContent">
        <div class="article">
            <?php echo $content ?>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>