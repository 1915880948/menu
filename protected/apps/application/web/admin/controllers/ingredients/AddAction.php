<?php

namespace application\web\admin\controllers\ingredients;

use application\models\base\Ingredients;
use application\web\admin\components\AdminBaseAction;

class AddAction extends AdminBaseAction
{
    public $method = 'post';
    public $responseType = 'json';

    public function run()
    {
        if ($this->request->isPost) {
            $postData = $this->request->post();
            $model = new Ingredients();
            $model->menu_id = $postData['menu_id'];
            $model->type_id = $postData['type_id'];
            $model->name = $postData['inger_name'];
            $model->amount = $postData['amount'];
            if ($model->save()) {
                return ['code' => 200, 'message' => 'add success!'];
            } else {
                return ['code' => 500, 'message' => $model->getErrors()];
            }
        }
    }
}