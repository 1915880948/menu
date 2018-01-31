<?php

namespace application\web\admin\controllers\step;

use application\models\base\Ingredients;
use application\models\base\Step;
use application\models\base\Tips;
use application\web\admin\components\AdminBaseAction;
use qiqi\helper\DataProviderHelper;

class IndexAction extends AdminBaseAction
{
    public function run($id = '', $menu = '')
    {
        $ingresQuery = Ingredients::find()
            ->andWhere(['status' => 1, 'menu_id' => $id])
            ->orderBy(['type_id' => SORT_ASC]);
        $stepQuery = Step::find()
            ->andWhere(['status' => 1, 'menu_id' => $id])
            ->orderBy(['step_number' => SORT_ASC]);
        $tipsQuery = Tips::find()
            ->andWhere(['status' => 1, 'menu_id' => $id])
            ->orderBy(['tip_number' => SORT_ASC]);
        $ingresList = DataProviderHelper::create($ingresQuery);
        $stepList = DataProviderHelper::create($stepQuery);
        $tipsList = DataProviderHelper::create($tipsQuery);
        return $this->render(compact('ingresList', 'stepList', 'tipsList'));
    }
}