<?php

namespace application\web\admin\controllers\type;

use application\models\base\MenuType;
use application\web\admin\components\AdminBaseAction;
use qiqi\helper\MessageHelper;

class DeleteAction extends AdminBaseAction
{
    public function run()
    {
        if (\Yii::$app->request->isPost) {
            \Yii::$app->response->format = 'json';
            $id = \Yii::$app->request->post('id');
            $model = MenuType::findByPk($id);
            $model->status = 0;
            if ($model->save()) {
                return ['code'=>200, 'message'=>'删除成功！'];
            }else{
                return ['code'=>500, 'message'=>$model->getErrors()];
            }
        }
    }
}