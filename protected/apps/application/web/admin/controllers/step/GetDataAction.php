<?php

namespace application\web\admin\controllers\step;

use application\models\base\Step;
use application\web\admin\components\AdminBaseAction;

class GetDataAction extends AdminBaseAction
{
    public function run()
    {
        if (\Yii::$app->request->isPost) {
            \Yii::$app->response->format = 'json';
            $postData = \Yii::$app->request->post();
            $data = Step::find()
                ->andWhere(['id' => $postData['id']])
                ->asArray()
                ->one();
            return $data;
        }

    }
}