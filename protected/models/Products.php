<?php

class Products extends CActiveRecord {

    public $options,$related_menu,$uploadDir;

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'products';
    }

    public function rules() {
        return array(
            array('title','file','on'=>'form','allowEmpty'=>false,'types'=>Yii::app()->params['allowedTypes'],'wrongType'=>'Wrong file type !','minSize'=>Yii::app()->params['minUploadSize'],'tooSmall'=>'File is too small !','maxSize'=>Yii::app()->params['maxUploadSize']),
            array('title','uploaded','on'=>'batch-form'),
            array('price, menu_id','numerical','integerOnly'=>true),
            array('price,menu_id','required','on'=>array('batch-form','form')),
            array('options,image_url,thumb_url,date_added','safe'),
            array('title,related_menu','safe','on'=>'search'),
            array('title,price,menu_id','required','on'=>'update'),
        );
    }

    // if upload directory is empty, no file was uploaded (at batch additions mode)
    public function uploaded() {
        $files=CFileHelper::findFiles($this->uploadDir);
        if (empty($files))
            $this->addError('title','No files were uploaded.');
    }
    
    public function relations() {
        return array(
            'menu'=>array(self::BELONGS_TO,'Menu','menu_id',),
            'feedbacks'=>array(self::HAS_MANY,'Feedbacks','product_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'title'=>'Photo(s)',
            'price'=>'Price',
            'options'=>'Options',
            'menu_id'=>'Menu',
            'image_url'=>'Image',
            'thumb_url'=>'Image',
            'date_added'=>'Added on',
        );
    }

    public function search() {
        $criteria=new CDbCriteria;
        $criteria->compare('title',$this->title,true);
        $criteria->compare('menu.name',$this->related_menu,true);
        return new CActiveDataProvider($this,array('criteria'=>$criteria,'sort'=>array(
                        'attributes'=>array(
                            'related_menu'=>array(
                                'asc'=>'menu.name',
                                'desc'=>'menu.name DESC',
                            ),
                            '*',
                        ),
                    ),));
    }

    protected function afterDelete() {
        parent::afterDelete();
        // Remove related feedbacks
        $models=Feedbacks::model()->findAll('',array(':product_id'=>$this->id));
        foreach ($models as $model) {
            $model->delete();
        }
        // Remove related pictures
        @unlink(Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.$this->thumb_url);
        @unlink(Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.$this->image_url);
    }

}
