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
    'components'=>array(
        'mailer'=>array(
            'class'=>'ext.swiftMailer.SwiftMailer',
            // For SMTP
            'mailer'=>'smtp',
            'host'=>'localhost',
            'port'=>25,
            'username'=>'',
            'password'=>'',
        ),
        'user'=>array(
            'allowAutoLogin'=>true,
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
        'maxUploadSize'=>67108864,//in bytes
        'allowedTypes'=>array('jpg','jpeg','png','gif'),
        'defaultOptions'=>'',
        'currencyCode'=>'USD',
        'currencySymbol'=>'$',
        'adminEmail'=>'admin@example.com',
        'metaDescription'=>'',// First part of the description
        'metaLang'=>'en',
        // Image vars 
        'previewMaxWidth'=>'30',// in percentages
        'maxWidth'=>'600',// products/details page (in px)
        'thumbnailWidth'=>150,// at thumbnail creation (in px)
        // Directories (from root path)
        'directories'=>array(
            'upload'=>'upload',
            'unzipped'=>'upload/unzipped',
            'images'=>'images/originals',
            'thumbnails'=>'images/thumbnails',
        )
    )
);
