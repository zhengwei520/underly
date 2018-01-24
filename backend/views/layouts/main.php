<?php

\common\hplus\assets\HplusAsset::register($this);
\common\widgets\ToastrAlert::widget([]);

$this->beginContent('@app/views/layouts/base.php');
?>

<body class="gray-bg">
    <?php
        if (Yii::$app->request->url !== '/dashboard/statistics') {
            $breadcrumbs = Yii::$app->nav->getBreadcrumb();
            if (!empty($this->title)) {
                $breadcrumbs[] = $this->title;
            }
            $currentUrl = parse_url(\Yii::$app->request->absoluteUrl);
            $path = isset($currentUrl['path']) ? $currentUrl['path'] : '/';
            $html = '<div class="row wrapper border-bottom white-bg page-heading">';
            $html .= '<div class="col-sm-12"><h2>' . $this->title . '</h2>';
            $html .= \common\widgets\nav\Breadcrumbs::widget([
                'links' => $breadcrumbs,
            ]);
            $html .= '</div></div>';
            echo $html;
        }
    ?>
    <div class="wrapper wrapper-content">
        <?php echo $content; ?>
    </div>
</body>

<?php
$this->endContent();
?>


