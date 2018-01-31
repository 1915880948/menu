<?php

namespace application\web\admin\controllers\ingredients;

use application\models\base\Ingredients;
use application\web\admin\components\AdminBaseAction;

class GetDataAction extends AdminBaseAction
{
    public $method = 'post';
    public $responseType = 'json';

    public function run()
    {
        if ($this->request->isPost) {
            $postData = $this->request->post();
            $data = Ingredients::find()
                ->andWhere(['id' => $postData['id']])
                ->asArray()
                ->one();
            return $data;
        }
    }
}