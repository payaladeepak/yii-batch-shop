<?php
class Products extends CActiveRecord {
    public $options,$menu_search;
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public static function getDataProvider($pageSize=50,$condition=null,$with=null,$order=null,$limit=null) {
        $c=($condition==null?'':$condition);
        return new CActiveDataProvider(self::model(),array('criteria'=>array(
            'condition'=>$c,
            'with'=>$with,
            'order'=>$order,
            'limit'=>$limit,
        ),'pagination'=>array(
            'pageSize'=>$pageSize,
        )));
    }
    public function tableName() {
        return 'products';
    }
    public function rules() {
        return array(
            array('title','file','on'=>'create','allowEmpty'=>false,'types'=>'jpg,jpeg,png,gif,zip','wrongType'=>'Wrong file type !','minSize'=>2048,'tooSmall'=>'File is too small !','maxSize'=>209715200),
            array('price, menu_id','numerical','integerOnly'=>true),
            array('price,menu_id','required'),
            array('options,image_url,thumb_url,date_added','safe'),
            array('title,menu_search','safe','on'=>'search'),
            array('title,price,menu_id','required','on'=>'update'),
            );
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
    protected function afterDelete() {
        parent::afterDelete();
        $rootPath=Yii::app()->getBasePath().'/..';
        @unlink($rootPath.$this->thumb_url);
        @unlink($rootPath.$this->image_url);
    }
}
