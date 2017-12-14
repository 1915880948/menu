<?php
namespace application\web\admin\controllers\sidebar;
use application\models\base\SidebarClick;
use application\web\admin\components\AdminBaseAction;
use qiqi\helper\DataProviderHelper;

class ListAction extends AdminBaseAction{
    public function run()
    {
        $query = SidebarClick::find()
            ->andWhere(['status'=>1])
            ->orderBy(['created_at'=>SORT_DESC]);
        $list = DataProviderHelper::create($query);

        $project = \Yii::$app->params['project'];
        $sidebar = \Yii::$app->params['sidebar'];
        return $this->render(compact('list','model','project','sidebar'));
    }

}