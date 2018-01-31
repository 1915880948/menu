<?php
namespace application\web\admin\controllers\step;
use application\models\base\Step;
use application\web\admin\components\AdminBaseAction;

class EditAction extends AdminBaseAction
{
    public function run()
    {
        if (\Yii::$app->request->isPost) {
            \Yii::$app->response->format = 'json';
            $postData = \Yii::$app->request->post();
            $model = Step::findByPk($postData['id']);
            if (trim($postData['images']) ){
                $imageArr = explode(',', trim($postData['images'], ','));
                $model->images = json_encode($imageArr);
            }

            $model->menu_id = $postData['menu_id'];
            $model->step_number = $postData['step_number'];
            $model->method = $postData['do_way'];
            $model->status = 1;
            $model->created_at = date('Y-m_d H:i:s');
            if ($model->save()) {
                return ['code' => 200, 'message' => 'add success!'];
            } else {
                return ['code' => 500, 'message' => $model->getErrors()];
            }
        }
    }
}