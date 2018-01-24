<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2018/1/24
 * Time: 上午12:24
 */

namespace common\widgets;


use common\assets\ToastrAsset;
use yii\helpers\Json;

class ToastrAlert  extends \yii\bootstrap\Widget
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
        $option = [
            'closeButton' => true,
            'debug' => false,
            'progressBar' => true,
            'positionClass' => 'toast-top-full-width',
            'onclick' => null,
            'showDuration' => 400,
            'hideDuration' => 1000,
            'timeOut' => 7000,
            'extendedTimeOut' => 1000,
            "showEasing" => "swing",
            "hideEasing" => "linear",
            "showMethod" => "fadeIn",
            "hideMethod" => "fadeOut"
        ];
        $session = \Yii::$app->session;
        $flashes = $session->getAllFlashes();
        if (!empty($flashes)) {
            $view = $this->getView();
            ToastrAsset::register($view);
            foreach ($flashes as $type => $data) {
                if (in_array($type, $this->alertTypes)) {
                    $view = $this->getView();
                    ToastrAsset::register($view);
                    $js = "toastr.options = ". Json::encode($option) .";";
                    $js .= 'toastr.'.$type.'("'.$data.'", "系统提示");';
                    $view->registerJs($js);
                    $session->removeFlash($type);
                }
            }
        }
    }
}