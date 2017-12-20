<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/17
 * Time: 下午8:44
 */



/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;

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
        <?php $this->beginBody() ?>
            <?= $content ?>
        <?php $this->endBody() ?>
    </html>
<?php $this->endPage() ?>