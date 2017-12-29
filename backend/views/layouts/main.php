<?php


\backend\assets\HplusMainAsset::register($this);


//$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ''];
//$this->params['breadcrumbs'][] = [
//    'label' => 'demo',
//    'url'   => 'http://example.com',
//    'class' => 'external',
//];

$this->beginContent('@app/views/layouts/base.php');
?>

<body class="gray-bg">

<?php

if (Yii::$app->request->url !== '/dashboard/statistics') {
    $breadcrumbs = '<div class="row wrapper border-bottom white-bg page-heading">';
    $breadcrumbs .= '<div class="col-sm-12"><h2>' . $this->title . '</h2>';
    $breadcrumbs .= \common\widgets\nav\Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]);
    $breadcrumbs .= '</div></div>';
    echo $breadcrumbs;
}

?>

<div class="wrapper wrapper-content">
    <?php echo $content; ?>
</div>
</body>

<?php
$this->endContent();
?>


