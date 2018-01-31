<?php

namespace application\web\admin\controllers\step;

use application\models\base\Step;
use application\web\admin\components\AdminBaseAction;

class SortAction extends AdminBaseAction
{
    public function run()
    {
        if (\Yii::$app->request->isPost) {
            \Yii::$app->response->format = 'json';
            $postData = \Yii::$app->request->post('sort');
            $tag = true;
            for ($i=0;$i<count($postData); $i++ ){
                $model = Step::findByPk($postData[$i]);
                $model->step_number = $i+1;
                if( !$model->save()){
                    $tag = false;
                }else{
                    continue;
                }
            }
            if ( $tag ) {
                return ['code' => 200, 'message' => 'add success!'];
            } else {
                return ['code' => 500, 'message' => '部分步骤没有更新'];
            }
        }
    }
}