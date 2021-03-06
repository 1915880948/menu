<?php
namespace application\web\admin\controllers\ingredients;
use application\models\base\Ingredients;
use application\web\admin\components\AdminBaseAction;
use qiqi\helper\MessageHelper;

class DeleteAction extends AdminBaseAction{
    public $method = 'post';
    public $responseType = 'json';

    public function run()
    {
        if ( $this->request->isPost ) {
            $id = $this->request->post('id');
            $model = Ingredients::findByPk($id);
            $model->status = 0;
            if ($model->save()) {
                return ['code'=>200, 'message'=>'删除成功！'];
            }else{
                return ['code'=>500,'message'=>$model->getErrors()];
            }
        }
    }
}