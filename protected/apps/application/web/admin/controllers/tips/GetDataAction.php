<?php

namespace application\web\admin\controllers\tips;

use application\models\base\Tips;
use application\web\admin\components\AdminBaseAction;

class GetDataAction extends AdminBaseAction
{
    public $method = 'post';
    public $responseType = 'json';

    public function run()
    {
        if ( $this->request->isPost) {
            $postData = \Yii::$app->request->post();
            $data = Tips::find()
                ->andWhere(['id' => $postData['id']])
                ->asArray()
                ->one();
            return $data;
        }
    }
}