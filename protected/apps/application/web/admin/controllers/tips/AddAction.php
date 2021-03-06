<?php

namespace application\web\admin\controllers\tips;

use application\models\base\Tips;
use application\web\admin\components\AdminBaseAction;

class AddAction extends AdminBaseAction
{
    public function run()
    {
        if (\Yii::$app->request->isPost) {
            \Yii::$app->response->format = 'json';
            $postData = \Yii::$app->request->post();
            $model = new Tips();
            $model->menu_id = $postData['menu_id'];
            $model->tip_number = $postData['tip_number'];
            $model->tip_name = $postData['tip_name'];
            if ($model->save()) {
                return ['code' => 200,'message'=>'success'];
            }else{
                return ['code'=>500,'message'=>$model->getErrors()];
            }
        }
    }
}