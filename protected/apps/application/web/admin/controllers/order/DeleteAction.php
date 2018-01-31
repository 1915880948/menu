<?php
namespace application\web\admin\controllers\order;
use application\models\base\Order;
use application\web\admin\components\AdminBaseAction;

class DeleteAction extends AdminBaseAction{
    public $method = 'post';
    public $responseType = 'json';

    public function run(){
        if( \Yii::$app->request->isPost ){
            $id = \Yii::$app->request->post('id');
            $model = Order::findByPk($id);
            $model->status = 0;
            if( $model->save() ){
                return ['code'=>200,'message'=>'success'];
            }else{
                return ['code'=>500,'message'=>$model->getErrors()];
            }
        }
    }
}