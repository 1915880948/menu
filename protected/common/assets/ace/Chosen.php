<?php
/**
 * @category Chosen
 * @author   gouki <gouki.xiao@gmail.com>
 * @created  15/7/21 09:53
 * @since
 */
namespace common\assets\ace;

use common\assets\ace\assets\ChosenAsset;
use yii\base\InvalidConfigException;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Widget;
use yii\db\ActiveRecord;

/**
 * Class Chosen
 *
 * @package common\assets\ace
 */
class Chosen extends Widget
{
    /**
     * @var ActiveForm
     */
    public $form;
    /**
     * @var ActiveRecord
     */
    public $model;
    public $attribute;
    public $label;
    public $sources;

    /**
     * Registers a specific Bootstrap plugin and the related events
     *
     * @param string $name the name of the Bootstrap plugin
     */
    protected function registerPlugin($name)
    {
        $view = $this->getView();
        ChosenAsset::register($view);
        //$view->registerCssFile('@webstatic/vendor/ace/assets/css/chosen.css', ['depends' => 'yii\web\JqueryAsset']);
        //$view->registerJsFile('@webstatic/vendor/ace/assets/js/chosen.jquery.min.js', ['depends' => 'yii\web\JqueryAsset', 'position' => View::POS_END,]);
        parent::registerPlugin($name);
    }

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $this->registerPlugin('chosen');

        return $this->renderItems();
    }

    /**
     * Renders tab items as specified on [[items]].
     *
     * @return string the rendering result.
     * @throws InvalidConfigException.
     */
    protected function renderItems()
    {
        if($this->model instanceof ActiveRecord){
            $f = $this->form->field($this->model, $this->attribute);
            if($this->label){
                $f->label($this->label);
            }
            return $f->dropDownList($this->sources, array_merge($this->options, ['class' => 'chosen-select col-xs-5']));
        }
    }
}
