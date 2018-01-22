<?php
namespace application\web\admin\controllers\step;
use application\models\base\step;
use application\web\admin\components\AdminBaseAction;
use qiqi\helper\MessageHelper;

class DeleteAction extends AdminBaseAction{
    public function run($id=''){
        $model = Step::findByPk($id);
        $model->status = 0;
        if( $model->save()){
            return MessageHelper::success('删除成功！！');
        }
    }
}
