<?php

common\hplus\assets\HplusAsset::register($this);
?>

<?php $this->beginContent('@app/views/layouts/base.php'); ?>
    <body class="gray-bg">
        <div class="middle-box text-center loginscreen  animated fadeInDown">
            <div>
                <?= $content ?>
            </div>
        </div>
    </body>
<?php $this->endContent(); ?>