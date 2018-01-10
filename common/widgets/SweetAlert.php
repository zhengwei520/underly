<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2018/1/10
 * Time: 下午11:37
 */

namespace common\widgets;


use common\assets\SweetAlertAsset;
use yii\helpers\Json;

class SweetAlert extends \yii\bootstrap\Widget
{

    public $alertTypes = [
        'error',
        'danger',
        'success',
        'info',
        'warning',
    ];

    public function init()
    {
        parent::init();
        $this->alert();
    }

    public function alert()
    {
        $session = \Yii::$app->session;
        $flashes = $session->getAllFlashes();
        if (!empty($flashes)) {
            $view = $this->getView();
            SweetAlertAsset::register($view);
            foreach ($flashes as $type => $data) {
                if (in_array($type, $this->alertTypes)) {
                    $option = [
                        'title' => $data,
                        'icon' => $type,
                        'timer' => 2000
                    ];
                    $js = "swal(". Json::encode($option) .")";
                    $view->registerJs($js);
                    $session->removeFlash($type);
                }
            }
        }
    }
}