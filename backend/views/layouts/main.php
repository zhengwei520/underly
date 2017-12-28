<?php

    \backend\assets\HplusMainAsset::register($this);

    $this->beginContent('@app/views/layouts/base.php');
?>

<body class="gray-bg">
    <div class="wrapper wrapper-content">
        <?php echo $content; ?>
    </div>
</body>

<?php
    $this->endContent();
?>


