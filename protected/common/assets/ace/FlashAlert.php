<?php
/**
 * @category FlashAlert
 * @author   gouki <gouki.xiao@gmail.com>
 * @created  15/3/6 下午6:43
 * @since
 */
namespace common\assets\ace;

use yii\bootstrap\Alert;

/**
 * Class FlashAlert
 * @package mobiadmin\widgets
 */
class FlashAlert extends \yii\bootstrap\Widget
{
    /**
     * @var array the alert types configuration for the flash messages.
     * This array is setup as $key => $value, where:
     * - $key is the name of the session flash variable
     * - $value is the bootstrap alert type (i.e. danger, success, info, warning)
     */
    public $alertTypes = [
        'error'   => 'alert-danger',
        'danger'  => 'alert-danger',
        'success' => 'alert-success',
        'info'    => 'alert-info',
        'warning' => 'alert-warning'
    ];
    /**
     * @var array the options for rendering the close button tag.
     */
    public $closeButton = [ ];

    public function init()
    {
        parent::init();
        $session = \Yii::$app->getSession();
        $flashes = $session->getAllFlashes();
        $appendCss = isset( $this->options['class'] ) ? ' ' . $this->options['class'] : '';
        $alerts = [ ];
        foreach ($flashes as $type => $data) {
            if ( !$data) {
                continue;
            }
            if (isset( $this->alertTypes[$type] )) {
                $data = (array) $data;
                foreach ($data as $message) {
                    $this->options['class'] = $this->alertTypes[$type] . $appendCss;
                    $this->options['id'] = $this->getId() . '-' . $type;
                    $alerts [] = Alert::widget( [
                        'body'        => $message,
                        'closeButton' => $this->closeButton,
                        'options'     => $this->options,
                    ] );
                }
                $session->removeFlash( $type );
            }
        }
        echo join( "", $alerts );
    }
}
