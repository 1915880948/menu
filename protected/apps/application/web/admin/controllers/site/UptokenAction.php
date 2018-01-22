<?php
namespace application\web\admin\controllers\site;
use application\web\admin\components\AdminBaseAction;
use Qiniu\Auth;
use yii\helpers\Json;

class UptokenAction extends AdminBaseAction{
    public function run(){
        \Yii::$app->response->format = 'json';
//        dd( $_SERVER );
        $auth = new Auth(env('QINIU_APP_KEY'), env('QINIU_APP_SECRET'));
        $token = $auth->uploadToken(env('QINIU_BUCKET'));

        return ['uptoken'=>$token];
    }
}