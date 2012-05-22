<?php

return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'My company',
    'theme'=>'freearch',
    'preload'=>array(
        'log'
    ),
    'import'=>array(
        'application.models.*',
        'application.components.*',
        'application.extensions.jtogglecolumn.*',
    ),
    'modules'=>array(
       /* 'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'0000',
            ),*/
        ),
    'components'=>array(
        'mailer'=>array(
            'class'=>'ext.swiftMailer.SwiftMailer',
            // For SMTP
            'mailer'=>'smtp',
            'host'=>'localhost',
            'port'=>6666,
            'username'=>'admin',
            'password'=>'0000',
        ),
        'user'=>array(
            'allowAutoLogin'=>true
        ),
        'pager'=>array(
            'SeoLinkPager'
        ),
        'simpleImage'=>array(
            'class'=>'application.extensions.CSimpleImage'
        ),
        'urlManager'=>array(
            'urlFormat'=>'path',
            'showScriptName'=>false,
            'rules'=>array(
                '<controller:\w+>/<action:page>/<view:.+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>/<id:\d+>/<title:.+>'=>'<controller>/<action>',
                '<controller:\w+>/<id:\d+>/<title:.+>'=>'<controller>',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
            ),
        ),
        'db'=>array(
            'connectionString'=>'mysql:host=localhost;dbname=db',
            'emulatePrepare'=>true,
            'username'=>'root',
            'password'=>'',
            'charset'=>'utf8'
        ),
        'errorHandler'=>array(
            'errorAction'=>'site/error'
        ),
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning'
                ),
                array(
                    'class'=>'CWebLogRoute'
                )
            )
        )
    ),
    'params'=>array(
        'minUploadSize'=>2048,//in bytes
        'maxUploadSize'=>209715200,//in bytes
        'allowedTypes'=>array('jpg','jpeg','png','gif'),
        'defaultOptions'=>"Size: Europe 39\nSize: Europe 40\nSize: Europe 41\nSize: Europe 42\nSize: Europe 43\nSize: Europe 44\nSize: Europe 45\nSize: Europe 46\nSize: Europe 47\nSize: UK 5\nSize: UK 5.5\nSize: UK 6\nSize: UK 7\nSize: UK 7.5\nSize: UK 8.5\nSize: UK 9\nSize: UK 10\nSize: UK 11\nSize: UK 12\nSize: USA 6\nSize: USA 6.5\nSize: USA 7\nSize: USA 8\nSize: USA 8.5\nSize: USA 9.5\nSize: USA 10\nSize: USA 11\nSize: USA 12\nSize: USA 13",
        'currencyCode'=>'USD',
        'currencySymbol'=>'$',
        'adminEmail'=>'admin@localhost',
        'metaDescription'=>'',
        'metaLang'=>'en',
        // Image vars 
        'previewMaxWidth'=>'30',// in percentages
        'maxWidth'=>'600',// products/details page (in px)
        'thumbnailWidth'=>150,// for thumbnail creation (in px)
        // Directories (from root path)
        'directories'=>array(
            'upload'=>'upload',
            'unzipped'=>'upload/unzipped',
            'images'=>'images/originals',
            'thumbnails'=>'images/thumbnails',
        )
    )
);