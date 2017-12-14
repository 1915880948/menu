<?php
namespace application\web\admin\controllers\postselect;
use application\web\admin\components\AdminBaseAction;

class SidebarAction extends AdminBaseAction{
    public function run(){
        \Yii::$app->response->format = 'json';
        $project_id = \Yii::$app->request->post('project_id');
        $sidebar = \Yii::$app->params['sidebar'] ;
        $side_list = [];
        for($i=20;$i<25;$i++){
            $side_list[$i] = $sidebar[$i];
        }
        return $side_list;
    }
}