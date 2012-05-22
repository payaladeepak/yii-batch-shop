<?php
class SeoLinkPager extends CLinkPager {
    public $headPrevNext=true;
    protected function createPageButton($label,$page,$class,$hidden,$selected) {
        if($hidden||$selected) 
            $class.=' '.($hidden?self::CSS_HIDDEN_PAGE:self::CSS_SELECTED_PAGE);
        $linkAttrs=array();
        $pageUrl=$this->createPageUrl($page);
        if($page==($this->currentPage-1)) {
            $linkAttrs['rel']='prev';
            if($this->headPrevNext) 
                Yii::app()->clientScript->registerLinkTag('prev',null,Yii::app()->request->getHostInfo().$pageUrl);
        }
        elseif($page==($this->currentPage+1)) {
            $linkAttrs['rel']='next';
            if($this->headPrevNext) 
                Yii::app()->clientScript->registerLinkTag('next',null,Yii::app()->request->getHostInfo().$pageUrl);
        }
        return '<li class="'.$class.'">'.CHtml::link($label,$pageUrl,$linkAttrs).'</li>';
    }
}