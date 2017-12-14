<?php
namespace application\web\admin\controllers\browser;

use application\models\base\Browserdate;
use application\web\admin\components\AdminBaseAction;
use qiqi\helper\DataProviderHelper;

class ListAction extends AdminBaseAction{
    public function run(){
        $query = Browserdate::find()
            ->andWhere(['status'=>1])
            ->orderBy(['created_at'=>SORT_DESC]);
        $list = DataProviderHelper::create( $query );

        $project = \Yii::$app->params['project'];
        return $this->render(compact('list','model','project'));
    }
}
