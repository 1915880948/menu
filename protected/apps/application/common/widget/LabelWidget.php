<?php
/**
 * @category LabelWidget
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/6/5 09:16
 * @since
 */
namespace application\common\widget;

use yii\base\Widget;
use yii\helpers\Html;

/**
 * Class LabelWidget
 * @package application\common\widget
 */
class LabelWidget extends Widget
{
    public $name = 'default';
    public $text = '';

    public function run()
    {
        return $this->generateLabel();
    }

    public function generateLabel()
    {
        $cls = 'label-' . $this->name;
        $options = ['label'];
        Html::addCssClass($options, $cls);
        return Html::tag('span', $this->text, ['class' => $options]);
    }
}
