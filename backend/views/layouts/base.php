<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/17
 * Time: 下午8:44
 */



/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\HplusAsset;
use yii\helpers\Html;

HplusAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
        <?= $content ?>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>z