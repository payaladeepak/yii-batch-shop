<?php $this->breadcrumbs=array(
	'Feedbacks',
);
?>
<h1>Feedbacks</h1>
<?php
$this->widget('CTabView', array(
    'cssFile'=>'/css/tabs.css',
    'tabs' => array(
        'tab1' => array(
            'title' => 'View feedbacks',
            'view' => '_list',
            'data' => array('dataProvider' => $dataProvider),
        ),
        'tab2' => array(
            'title' => 'Post a feedback',
            'view' => '_form',
            'data' => array('model' => $model),
        ),
    )
));
?>