<?php
namespace application\web\admin\controllers\docu;
use application\models\base\Docustatistical;
use application\web\admin\components\AdminBaseAction;
use qiqi\helper\DataProviderHelper;

class ListAction extends AdminBaseAction{
    public function run(){
        $query = Docustatistical::find()
            ->andWhere(['status'=>1])
            ->orderBy(['created_at'=>SORT_DESC]);
        $list = DataProviderHelper::create($query);

        $project = \Yii::$app->params['project'];
        $docu = \Yii::$app->params['docu'];
        return $this->render(compact('list','model','project','docu'));
    }
}