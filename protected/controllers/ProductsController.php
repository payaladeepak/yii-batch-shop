<?php

class ProductsController extends Controller {

    public $defaultAction='random';
    public $thumbHeight,$thumbWidth,$imgDir,$thumbsDir,$uploadDir,$unzippedDir,$zip,$model;

    public function init() {
        $this->uploadDir=Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.Yii::app()->params['directories']['upload'];
        $this->unzippedDir=Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.Yii::app()->params['directories']['unzipped'];
        $this->imgDir=Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.Yii::app()->params['directories']['images'];
        $this->thumbsDir=Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.Yii::app()->params['directories']['thumbnails'];

        if (Yii::app()->user->isGuest)
            Yii::app()->clientScript->registerCssFile(Yii::app()->getBaseUrl().DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'menu.css');
    }

    public function filters() {
        return array('accessControl');
    }

    public function accessRules() {
        return array(
            array('allow','actions'=>array('index','details','search','captcha','random'),'users'=>array('*')),
            array('allow','users'=>array('admin')),
            array('deny','users'=>array('*')),
        );
    }

    public function missingAction() {
        $this->actionRandom();
    }

    public function actionSearch() {
        $search=Yii::app()->request->getQuery('Products');
        if (!empty($search['search'])) {
            $criteria=new CDbCriteria;
            $criteria->compare('title',$search['search'],true);
            $dataSet=new CActiveDataProvider('Products',array('criteria'=>$criteria,'pagination'=>array(
                            'pageSize'=>50,
                        ),));
        } else {
            $dataSet=new CActiveDataProvider('Products');
            $dataSet->setData(array());
        }
        $this->render('results',array('dataSet'=>$dataSet,));
    }
    public function actionAdd() {
        $this->model=new Products('add');
        $this->model->options=Yii::app()->params['defaultOptions'];
        if (Yii::app()->request->isPostRequest) {
            $this->model->setAttributes($_POST['Products']);
            if ($this->model->validate()) {
                $this->thumbWidth=Yii::app()->params['thumbnailWidth'];
                $this->_buildPath($this->imgDir);
                $this->_buildPath($this->thumbsDir);
                $this->_buildPath($this->uploadDir);
                $uploadedFile=CUploadedFile::getInstance($this->model,'title');
                $fullPath=$this->uploadDir.DIRECTORY_SEPARATOR.$uploadedFile->getName();
                $ext=CFileHelper::getExtension($fullPath);
                $newFileName=$this->_newFileName($ext);
                if ($uploadedFile->saveAs($fullPath)===true) {
                    $this->_save($newFileName,$fullPath,$ext,false);
                } else {
                    $this->model->addError('title','There was an error while trying to upload');
                    $this->render('create',array('listData'=>$this->_selectList()));
                }
                $this->_emptyDir($this->uploadDir);
                $this->redirect('admin');
            } else {
                $this->render('create',array('listData'=>$this->_selectList()));
            }
        } else {
            $this->_emptyDir($this->uploadDir);
            $this->render('create',array('listData'=>$this->_selectList()));
        }
    }
    
    public function actionBatchAdd() {
        $this->model=new Products('batch-add');
        $this->model->options=Yii::app()->params['defaultOptions'];
        if (Yii::app()->request->isPostRequest) {
            $this->model->setAttributes($_POST['Products']);
            $this->model->uploadDir=$this->uploadDir;
            if (!$this->model->validate()) {
                $this->render('create',array('listData'=>$this->_selectList()));
                Yii::app()->end();
            }
            $this->thumbWidth=Yii::app()->params['thumbnailWidth'];
            $this->_buildPath($this->imgDir);
            $this->_buildPath($this->thumbsDir);
            $this->_buildPath($this->unzippedDir);
            $this->_processFiles($this->uploadDir);
            $this->_emptyDir($this->uploadDir);
            $this->redirect('admin');
        } else {
            $this->_emptyDir($this->uploadDir);
            $this->render('create',array('listData'=>$this->_selectList()));
        }
    }
    
    public function actionUpdate($id) {
        $this->loadModel($id,'','update');
        Yii::app()->session->add('item',$this->model->getAttribute('title'));
        if (Yii::app()->request->getPost('Products')) {
            $this->model->setAttributes($_POST['Products']);
            if ($this->model->save())
                $this->redirect(array('admin'));
        }
        $this->model->setIsNewRecord(false);
        $this->render('update',array('listData'=>$this->_selectList()));
    }

    public function actionBatchDelete() {
        if (Yii::app()->request->isPostRequest) {
            if (Yii::app()->request->getPost('id')) {
                foreach ($_POST['id'] as $v) {
                    $this->loadModel($v);
                    $this->model->delete();
                }
                if (!isset($_GET['ajax']))
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
            else {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $this->loadModel($id);
            $this->model->delete();
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    protected function loadModel($id,$with=null,$scenario=null) {
        if (!empty($with))
            $this->model=Products::model()->with($with)->findByPk($id);
        else
            $this->model=Products::model()->findByPk($id);
        if ($this->model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        if (!empty($scenario))
            $this->model->setScenario($scenario);
    }

    public function actionIndex($id) {
        $dataSet=new CActiveDataProvider('Products',array('criteria'=>array(
                        'condition'=>'menu_id='.$id,
                    ),'pagination'=>array(
                        'pageSize'=>50,
                        )));
        $menu=Menu::model()->findByPk($id);
        $this->_loadBreadcrumbs($menu);
        $this->render('index',array('dataSet'=>$dataSet,'title'=>$menu->name));
    }

    public function actionRandom() {
        // Page with random products
        $dataSet=new CActiveDataProvider('Products',array('criteria'=>array(
                        'order'=>new CDbExpression('RAND()'),
                        'limit'=>50,
                    ),'pagination'=>false
                ));
        $this->render('random',array('dataSet'=>$dataSet));
    }

    public function actionDetails($id) {
        $this->loadModel($id);
        $feedbacks=new Feedbacks;
        if (isset($_POST['Feedbacks'])) {
            $feedbacks->attributes=$_POST['Feedbacks'];
            $feedbacks->date_added=time();
            $feedbacks->product_id=$id;
            if ($feedbacks->save()) {
                // Notify admin via email
                Yii::app()->mailer->AddAddress(Yii::app()->params['adminEmail']);
                Yii::app()->mailer->From=Yii::app()->params['adminEmail'];
                Yii::app()->mailer->Subject=Yii::app()->name.' - A new feedback was received';
                Yii::app()->mailer->MsgHTML(
                        'A new feedback was received, you\'ll have to approve it to enable its display<br/>
                        <a href"'.Yii::app()->request->hostInfo.Yii::app()->request->requestUri.'">Click here</a> to quickly jump to the product page.'
                );
                Yii::app()->mailer->Send();
                Yii::app()->user->setFlash('feedback','Your feedback was received, it will be visible once it is approved.');
                $this->refresh(); 
            }
        }
        $options=explode("\n",$this->model->options);
        $this->_loadBreadcrumbs($this->model->menu,$this->model->menu->id);
        $itemCat=$this->_itemCat($this->breadcrumbs);
        array_push($this->breadcrumbs,$this->model->title);
        $this->render('details',array(
            'options'=>$options,
            'itemCat'=>$itemCat,
            'dataProvider'=>new CActiveDataProvider('Feedbacks',array(
                'criteria'=>array(
                    'condition'=>'`product_id`='.$id.(Yii::app()->user->isGuest?' AND `approved`=1':''),
                ),
                    )
            ),
            'feedbacks'=>$feedbacks,
        ));
    }

    public function actionAdmin() {
        $model=new Products('search');
        $model->unsetAttributes();
        $this->model=$model->with('menu');
        if (isset($_GET['Products']))
            $this->model->setAttributes($_GET['Products']);
        $this->render('admin');
    }

    private function _itemCat($breadcrumbs) {
        $arr=array_keys($breadcrumbs);
        array_shift($arr);
        return implode(DIRECTORY_SEPARATOR,$arr);
    }

    private function performAjaxValidation($model) {
        if (isset($_POST['ajax'])&&$_POST['ajax']==='products-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    private function _buildPath($dir) {
        if (file_exists($dir)||empty($dir))
            return false;
        $array=$this->_dirList($dir);
        foreach ($array as $value) {
            if (file_exists($value))
                continue;
            mkdir($value);
        }
        return true;
    }

    private function _dirList($dir) {
        // remove ending slash
        $dir=(substr($dir,-1)==DIRECTORY_SEPARATOR ? substr($dir,0,-1) : $dir);
        $isUnix=($dir[0]==DIRECTORY_SEPARATOR ? true : false);
        $e=explode(DIRECTORY_SEPARATOR,$dir);
        $c=count($e);
        $list=array();
        if ($isUnix) {
            $list[0]=DIRECTORY_SEPARATOR;
            for ($i=0; $i!=$c; $i++) {
                if (empty($e[$i]))
                    continue;
                $list[$i]=$list[$i-1].$e[$i].DIRECTORY_SEPARATOR;
            }
        }
        else {
            for ($i=0; $i!=$c; $i++) {
                if ($i==0)
                    $list[$i]=$e[$i].DIRECTORY_SEPARATOR;
                else
                    $list[$i]=$list[$i-1].$e[$i].DIRECTORY_SEPARATOR;
            }
        }
        return $list;
    }

    private function _randomString($length=10,$chars='',$type=array()) {
        $alphaSmall='abcdefghijklmnopqrstuvwxyz';
        $alphaBig='ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num='0123456789';
        $othr='`~!@#$%^&*()/*-+_=[{}]|;:",<>.\/?'."'";
        $characters="";
        $string='';
        isset($type['alphaSmall']) ? $type['alphaSmall'] : $type['alphaSmall']=true;
        isset($type['alphaBig']) ? $type['alphaBig'] : $type['alphaBig']=true;
        isset($type['num']) ? $type['num'] : $type['num']=true;
        isset($type['othr']) ? $type['othr'] : $type['othr']=false;
        isset($type['duplicate']) ? $type['duplicate'] : $type['duplicate']=true;
        if (strlen(trim($chars))==0) {
            $type['alphaSmall'] ? $characters.=$alphaSmall : $characters=$characters;
            $type['alphaBig'] ? $characters.=$alphaBig : $characters=$characters;
            $type['num'] ? $characters.=$num : $characters=$characters;
            $type['othr'] ? $characters.=$othr : $characters=$characters;
        }
        else
            $characters=str_replace(' ','',$chars);
        if ($type['duplicate'])
            for (; $length>0&&strlen($characters)>0; $length--) {
                $ctr=mt_rand(0,(strlen($characters))-1);
                $string.=$characters[$ctr];
            }
        else
            $string=substr(str_shuffle($characters),0,$length);
        return $string;
    }

    private function _selectList() {
        $categories=Menu::model()->findAll(array('order'=>'root,lft'));
        $level=0;
        $indent='';
        $listData=array();
        foreach ($categories as $n=>$category) {
            if ($category->level==$level) {
                
            } elseif ($category->level>$level) {
                $indent.='--';
            } else {
                $indent=substr($indent,-2);
            }
            $listData[$category->id]=$indent.$category->name;
            $level=$category->level;
        }
        return $listData;
    }

    private function _processFiles($path) {
        $fileList=CFileHelper::findFiles($path);
        $c=count($fileList)-1;
        while ($c!=-1) {
            // if the uploaded zip file contains another zip file, extract it to a new subdir and process it
            if (CFileHelper::getMimeType($fileList[$c])=='application/zip') {
                $path=$this->_processZip($fileList[$c]);
                // If successfull zip extraction, process the new extracted files
                if ($path!=false) {
                //    print_r($path);exit;
                   
                    $this->_processFiles($path);
                  //  continue;
                }
                
            }
            $ext=CFileHelper::getExtension($fileList[$c]);
            $newFileName=$this->_newFileName($ext);
            $this->_save($newFileName,$fileList[$c],$ext);
            $c--;
        }
        return true;
    }
    
    private function _processZip($file) {
        if (empty($this->zip))
            $this->zip=new ZipArchive;
        if ($this->zip->open($file)===true) {
            $extractTo=$this->_newSubDir($this->unzippedDir);
            $this->zip->extractTo($extractTo);
            $this->zip->close();
            return $extractTo;
        }
        return false;
    }

    private function _newSubDir($path) {
        while (true) {
            $str=$this->_randomString(10,'',array('alphaSmall'=>true,'alphaBig'=>false,'num'=>true,'othr'=>false));
            $subdir=$path.DIRECTORY_SEPARATOR.$str;
            if (file_exists($subdir))
                continue;
            mkdir($subdir);
            break;
        }
        return $subdir;
    }

    private function _isEmptyDir($path) {
        $files=scandir($path);
        if ($files!=false&&(count($files)>2)) {
            return false;
        }
        return true;
    }
    
    private function _save($newFileName,$fullPath,$ext,$zipFile=true) {
        if ($zipFile==true)
            if (!in_array($ext,Yii::app()->params['allowedTypes']))
                return false;
        $e=end(explode(DIRECTORY_SEPARATOR,$fullPath));
        $title=substr($e,0,((strlen($e)-strlen($ext))-1));
        rename($fullPath,$this->imgDir.DIRECTORY_SEPARATOR.$newFileName);
        $this->_thumbnail($this->imgDir.DIRECTORY_SEPARATOR.$newFileName,$this->thumbsDir.DIRECTORY_SEPARATOR.$newFileName);
        $time=time();
        $this->model->setIsNewRecord(true);
        $this->model->setPrimaryKey(NULL);
        $this->model->setAttributes(array(
            'title'=>$title,
            'image_url'=>DIRECTORY_SEPARATOR.Yii::app()->params['directories']['images'].DIRECTORY_SEPARATOR.$newFileName,
            'thumb_url'=>DIRECTORY_SEPARATOR.Yii::app()->params['directories']['thumbnails'].DIRECTORY_SEPARATOR.$newFileName,
            'date_added'=>$time,
        ));
        $this->model->save(false);
    }

    private function _thumbnail($input,$output) {
        if (file_exists($input)!=false) {
            $imgObj=Yii::app()->simpleImage->load($input);
            if (empty($this->thumbHeight)) {
                $imgObj->resizeToWidth($this->thumbWidth);
            } else {
                $imgObj->resize($this->thumbWidth,$this->thumbHeight);
            }
            return $imgObj->save($output);
        }
    }

    private function _emptyDir($dir,$DeleteMe=false) {
        if (!$dh=@opendir($dir))
            return;
        while (false!==($obj=readdir($dh))) {
            if ($obj=='.'||$obj=='..')
                continue;
            if (!@unlink($dir.DIRECTORY_SEPARATOR.$obj))
                $this->_emptyDir($dir.DIRECTORY_SEPARATOR.$obj,true);
        }
        closedir($dh);
        if ($DeleteMe) {
            @rmdir($dir);
        }
    }

    private function _newFileName($ext) {
        while (true) {
            $str=$this->_randomString(10,'',array('alphaSmall'=>true,'alphaBig'=>false,'num'=>true,'othr'=>false));
            $newFileName=$str.'.'.$ext;
            if (!file_exists($this->imgDir.DIRECTORY_SEPARATOR.$newFileName)) {
                break;
            } else {
                continue;
            }
        }
        return $newFileName;
    }

    public function actionUploadResponse() {
        $this->_buildPath($this->uploadDir);
        Yii::import("ext.EAjaxUpload.qqFileUploader");
        $allowedExtensions=array_merge(Yii::app()->params['allowedTypes'],array('zip'));
        $sizeLimit=Yii::app()->params['maxUploadSize'];
        $uploader=new qqFileUploader($allowedExtensions,$sizeLimit);
        $result=$uploader->handleUpload($this->uploadDir.DIRECTORY_SEPARATOR);
        $return=htmlspecialchars(json_encode($result),ENT_NOQUOTES);
        // optional
    //  $fileSize=filesize($this->uploadDir.DIRECTORY_SEPARATOR.$result['filename']);
    //  $fileName=$result['filename'];
        echo $return;
    }

}
