<?php
/**
 * @category ChosenWidget
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/5/4 15:57
 * @since
 */
namespace application\web\admin\components\assets\widget;

use yii\base\Widget;
use yii\web\View;

/**
 * Class ChosenWidget
 * @package application\web\admin\components\assets\widget
 */
class ChosenWidget extends Widget
{
    public $className = 'chosen-select';
    public $selectId  = '';

    public function run()
    {
        $view = $this->getView();
//        CategoryAsset::register($view);
        $js = <<<EOT
$('.{$this->className}').chosen();
EOT;

        $view->registerJs($js, View::POS_READY);
    }
}
