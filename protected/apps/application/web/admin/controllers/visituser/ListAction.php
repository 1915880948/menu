<?php
namespace application\web\admin\controllers\visituser;
use application\models\base\Visituserdata;
use application\web\admin\components\AdminBaseAction;
use qiqi\helper\DataProviderHelper;

class ListAction extends AdminBaseAction{
    public function run()
    {
        $query = Visituserdata::find()
            ->andWhere(['status'=>1])
            ->orderBy(['created_at'=>SORT_DESC]);
        $list = DataProviderHelper::create($query);
        $model = new Visituserdata();
        $model->loadDefaultValues();
        return $this->render(compact('list'));
    }
}