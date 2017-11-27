<?php
/**
 * @category ModalWidget
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/5/10 17:23
 * @since
 */
namespace application\common\widget;

use yii\bootstrap\Html;
use yii\bootstrap\Modal;

/**
 * Class ModalWidget
 * @package application\common\widget
 */
class ModalWidget extends Modal
{
    public $content;

    /**
     * Renders the widget.
     */
    public function run()
    {
        if($this->content){
            echo "\n" . $this->content;
        }
        echo "\n" . $this->renderBodyEnd();
        echo "\n" . $this->renderFooter();
        echo "\n" . Html::endTag('div'); // modal-content
        echo "\n" . Html::endTag('div'); // modal-dialog
        echo "\n" . Html::endTag('div');

        $this->registerPlugin('modal');
    }
}
