<?php

class Products extends CActiveRecord {

    public $options,$menu_search,$uploadDir,$image;

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'products';
    }

    public function rules() {
        return array(
            array('title','file','on'=>'add','allowEmpty'=>false,'types'=>Yii::app()->params['allowedTypes'],'wrongType'=>'Wrong file type !','minSize'=>Yii::app()->params['minUploadSize'],'tooSmall'=>'File is too small !','maxSize'=>Yii::app()->params['maxUploadSize']),
           // array('title','file','on'=>'batch-add','allowEmpty'=>false,'types'=>,'wrongType'=>'Wrong file type !','minSize'=>Yii::app()->params['minUploadSize'],'tooSmall'=>'File is too small !','maxSize'=>Yii::app()->params['maxUploadSize']),
            array('title','uploaded','on'=>'batch-add'),
            array('extension','extension','on'=>'batch-add','extensions'=>array_merge(Yii::app()->params['allowedTypes'],array('zip'))),
            array('price, menu_id','numerical','integerOnly'=>true),
            array('price,menu_id','required'),
            array('options,image_url,thumb_url,date_added','safe'),
            array('title,menu_search','safe','on'=>'search'),
            array('title,price,menu_id','required','on'=>'update'),
        );
    }

    // if upload directory is empty, no file was uploaded (for batch additions mode)
    public function uploaded() {
        $files=CFileHelper::findFiles($this->uploadDir);
        if (empty($files))
            $this->addError('title','No file was uploaded');
    }

    public function extension($attribute,$params) {
        if (in_array($this->image,$params['extensions']))
            return true;
        return false;
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
        $criteria->compare('menu.name',$this->menu_search,true);
        return new CActiveDataProvider($this,array('criteria'=>$criteria,'sort'=>array(
                        'attributes'=>array(
                            'menu_search'=>array(
                                'asc'=>'menu.name',
                                'desc'=>'menu.name DESC',
                            ),
                            '*',
                        ),
                    ),));
    }

    public function getReadableFileSize($retstring=null) {
        // adapted from code at http://aidanlister.com/repos/v/function.size_readable.php
        $sizes=array('bytes','kB','MB','GB','TB','PB','EB','ZB','YB');
        if ($retstring===null) {
            $retstring='%01.2f %s';
        }
        $lastsizestring=end($sizes);
        foreach ($sizes as $sizestring) {
            if ($this->size<1024) {
                break;
            }
            if ($sizestring!=$lastsizestring) {
                $this->size /= 1024;
            }
        }
        if ($sizestring==$sizes[0]) {
            $retstring='%01d %s';
        } // Bytes aren't normally fractional
        return sprintf($retstring,$this->size,$sizestring);
    }

    protected function afterDelete() {
        parent::afterDelete();
        $rootPath=Yii::app()->getBasePath().'/..';
        @unlink($rootPath.$this->thumb_url);
        @unlink($rootPath.$this->image_url);
    }

}
