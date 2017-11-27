<?php
/**
 * @category InlineForm
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 15/12/15 22:02
 * @since
 */
namespace common\assets\ace;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * Class InlineForm
 * @package common\assets\ace
 */
class InlineForm extends ActiveForm
{
    static public function begin($config = [])
    {
        $config = ArrayHelper::merge(['class' => 'form-inline', 'method' => 'get'], $config);
        return parent::begin($config); // TODO: Change the autogenerated stub
    }

    public function label($name, $input, $options = [])
    {
        $string = $input;
        if($name){
            $string = "{$name} : {$input}";
        }

        return Html::label($string, $options);
    }

    public function submitInput($string = "Search")
    {
        return Html::label("&nbsp;" . Html::submitInput($string, [
                'class' => 'input-group-btn btn btn-purple btn-sm input-small ',
                'type'  => 'submit',
            ]));
    }

    public function resetInput($string = "重置")
    {
        return Html::label("&nbsp;" . Html::resetInput($string, [
                'class'   => 'input-group-btn btn btn-default btn-sm input-small ',
                'onclick' => 'location.href=this.form.action'
            ]));
    }
}


/**
 * <div class="widget-box">
 * <div class="widget-header">
 * <h4>Inline Forms</h4>
 * </div>
 *
 * <div class="widget-body">
 * <div class="widget-main">
 * <form class="form-inline">
 * <input type="text" class="input-small" placeholder="Username" />
 * <input type="password" class="input-small" placeholder="Password" />
 * <label class="inline">
 * <input type="checkbox" class="ace" />
 * <span class="lbl"> remember me</span>
 * </label>
 *
 * <button type="button" class="btn btn-info btn-sm">
 * <i class="icon-key bigger-110"></i>
 * Login
 * </button>
 * <span class="input-group-btn">
 * <button type="button" class="btn btn-purple btn-sm">
 * Search
 * <i class="icon-search icon-on-right bigger-110"></i>
 * </button>
 * </span>
 *
 * </form>
 * </div>
 * </div>
 * </div>
 */