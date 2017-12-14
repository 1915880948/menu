<?php
namespace application\web\admin\controllers\postselect;
use application\web\admin\components\AdminBaseAction;

class DocuAction extends AdminBaseAction{
    public function run(){
        \Yii::$app->response->format = 'json';
        $project_id = \Yii::$app->request->post('project_id');
        $docu = \Yii::$app->params['docu'] ;
        $docu_list = [];
        for($i=10;$i<20;$i++){
            $docu_list[$i] = $docu[$i];
        }
        return $docu_list;
    }
}