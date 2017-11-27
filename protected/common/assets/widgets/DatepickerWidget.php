<?php
/**
 * @category DatepickerWidget
 * @author   gouki <gouki.xiao@gmail.com>
 * @created  15/3/11 下午6:47
 * @since
 */
namespace common\assets\widgets;

use common\base\bundle\DatePickerAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use yii\widgets\InputWidget;

/**
 * Class DatepickerWidget
 * @package common\base\widgets
 */
class DatepickerWidget extends InputWidget
{
    /**
     * DateTime format string
     * @var null
     */
    public $format = 'yyyy-mm-dd';//dd/MM/yyyy hh:mm:ss

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @return string
     */
    public function run()
    {
        $this->registerClientScript();
        $options = ArrayHelper::merge( $this->options, [ 'class' => 'form-control' ] );
        $options['data-date-format'] = $this->format;
        $this->options = $options;
        return sprintf( "<div class='date_%s'>%s</div>", $this->options['id'], ( $this->hasModel()
            ? Html::activeTextInput( $this->model, $this->attribute, $options ) : Html::textInput( $this->name, $this->value, $options ) ) );
    }

    /**
     * Registering Client Scripts.
     */
    protected function registerClientScript()
    {
        $view = $this->getView();
        $selector = Json::encode( '#' . $this->options['id'] );
        //$selector = Json::encode( '.date_' . $this->options['id'] );
        $options = !empty( $this->clientOptions ) ? Json::encode( $this->clientOptions ) : '';
        DatePickerAsset::register( $view );
        //$view->registerJs( "\$($selector).datetimepicker($options);" );
        $view->registerJs( "\$(function(){\$({$selector}).datepicker({$options});});", View::POS_END );
    }
}
