<?php

namespace application\web\admin\controllers\tag;

use application\models\base\MenuTag;
use application\web\admin\components\AdminBaseAction;
use qiqi\helper\MessageHelper;

class DeleteAction extends AdminBaseAction
{
    public $method = 'post';
    public $responseType = 'json';
    public function run()
    {
        if (\Yii::$app->request->isPost) {
            $id = \Yii::$app->request->post('id');
            $model = MenuTag::findByPk($id);
            $model->status = 0;
            if ($model->save()) {
                return ['code' => 200, 'message' => 'success'];
            } else {
                return ['code' => 500, 'message' => $model->getErrors()];
            }


        }
    }
}