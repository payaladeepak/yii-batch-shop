<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/js/imgpreview.min.0.22.jquery.js');?>
<?php Yii::app()->getClientScript()->registerScript('preview',
        '$(document).ready(function() {
            var w = (screen.width*'.Yii::app()->params['previewMaxWidth'].')/100;
            var xOffset = -screen.width/3.2;
            var yOffset = xOffset*0.6;
            $(\'.preview\').imgPreview({
            srcAttr: \'rel\',
            distanceFromCursor: { top: yOffset, left: xOffset },
            imgCSS: { width: w }
        });
        });');?>