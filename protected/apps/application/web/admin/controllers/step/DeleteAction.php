<?php
namespace application\web\admin\controllers\step;
use application\models\base\step;
use application\web\admin\components\AdminBaseAction;
use qiqi\helper\MessageHelper;

class DeleteAction extends AdminBaseAction{
    public $method = 'post';
    public $responseType = 'json';

    public function run(){
        if(\Yii::$app->request->isPost) {
            $id = \Yii::$app->request->post('id');
            $model = Step::findByPk($id);
            $model->status = 0;
            if ($model->save()) {
                return ['code' => 200, 'message' => 'delete success!'];
            } else {
                return ['code' => 500, 'message' => $model->getErrors()];
            }
        }
    }
}
