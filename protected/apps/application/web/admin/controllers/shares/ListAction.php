<?php
namespace application\web\admin\controllers\shares;
use application\models\base\SharesNum;
use application\web\admin\components\AdminBaseAction;
use qiqi\helper\DataProviderHelper;

class ListAction extends AdminBaseAction{

    public function run()
    {
        $query = SharesNum::find()
            ->andWhere(['status'=>1])
            ->orderBy(['created_at'=>SORT_DESC]);
        $list = DataProviderHelper::create($query);

        $project = \Yii::$app->params['project'];
        $docu = \Yii::$app->params['docu'];
        return $this->render(compact('list','project','docu'));
    }

}