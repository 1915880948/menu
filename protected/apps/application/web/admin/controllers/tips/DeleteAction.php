<?php
namespace application\web\admin\controllers\tips;
use application\models\base\Tips;
use application\web\admin\components\AdminBaseAction;
use qiqi\helper\MessageHelper;

class DeleteAction extends AdminBaseAction{
    public $method = 'post';
    public $responseType = 'json';

    public function run(){
        if( \Yii::$app->request->isPost ){
            $id = \Yii::$app->request->post('id');
            $model = Tips::findByPk($id);
            $model->status = 0;
            if( $model->save() ){
                return ['code'=>200, 'message'=>'删除成功！'];
            }else{
                return ['code'=>500,'message'=>$model->getErrors()];
            }
        }
    }
}