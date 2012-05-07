<?php Yii::app()->getClientScript()->registerScriptFile('/js/imgpreview.min.0.22.jquery.js');?>
<?php Yii::app()->getClientScript()->registerScript('preview',
        '$(document).ready(function() {
            var w = screen.width/3;
            var xOffset = -screen.width/2.9;
            var yOffset = xOffset*0.5;
            $(\'.preview\').imgPreview({
            srcAttr: \'rel\',
            distanceFromCursor: { top: yOffset, left: xOffset },
            imgCSS: { width: w }
        });
        });');?>