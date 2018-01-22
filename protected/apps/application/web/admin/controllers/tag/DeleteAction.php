<?php
namespace application\web\admin\controllers\tag;
use application\models\base\MenuTag;
use application\web\admin\components\AdminBaseAction;
use qiqi\helper\MessageHelper;

class DeleteAction extends AdminBaseAction{
    public function run($id){
        $model = MenuTag::findByPk($id);
        $model->status = 0;
        if( $model->save() ){
            return MessageHelper::success('删除成功！');
        }
    }
}