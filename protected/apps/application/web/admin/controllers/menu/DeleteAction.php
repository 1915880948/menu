<?php
namespace application\web\admin\controllers\menu;
use application\models\base\Menu;
use application\web\admin\components\AdminBaseAction;

class DeleteAction extends AdminBaseAction{
    public $method = 'post';
    public $responseType = 'json';
    public function run(){
        if( $this->request->isPost ){
            $id = \Yii::$app->request->post('id');
            $model = Menu::findByPk($id);
            $model->status = 0;
            if( $model->save() ){
                return ['code'=>200, 'message'=>'删除成功！'];
            }else{
                return ['code'=>500,'message'=>$model->getErrors()];
            }
        }
    }
}