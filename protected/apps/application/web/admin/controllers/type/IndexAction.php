<?php
namespace application\web\admin\controllers\type;
use application\models\base\MenuType;
use application\web\admin\components\AdminBaseAction;
use qiqi\helper\DataProviderHelper;
use qiqi\helper\MessageHelper;

class IndexAction extends AdminBaseAction{
    public function run($id = ''){
        $model = MenuType::findByPk($id);
        if( !$model ){
            $model = new MenuType();
            $model->loadDefaultValues();
        }
        $query = MenuType::find()
            ->andWhere(['status'=>1])
            ->orderBy(['created_at'=>SORT_DESC]);
        $list = DataProviderHelper::create( $query,3 );
        if( \Yii::$app->request->isPost ){
            $data = $this->request->post();
                $model->type_name  = $data['MenuType']['type_name'];
                $model->created_at = date('Y-m-d H:i:s');
                if( $model->save() ){
                    return MessageHelper::success(($id?'修改':'新增').'成功！',['']);
                }

        }
        return $this->render(compact('model','list'));
    }
}