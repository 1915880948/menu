<?php
/**
 * @category SearchWidget
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/5/12 19:29
 * @since
 */
namespace common\assets\widgets;

use common\assets\ace\InlineForm;
use yii\bootstrap\Html;
use yii\bootstrap\Widget;

/**
 * Class SearchWidget
 * @package common\assets\widgets
 */
class SearchWidget extends Widget
{
    public $forms;

    public function run()
    {
        if(!$this->forms){
            return;
        }
        $form = InlineForm::begin(['action' => $this->forms['action'], 'options' => ['class' => 'form-search']]);
        echo Html::tag('span',
                Html::input('text', 'keywords',\Yii::$app->request->get('keywords', ''), [
                    'placeholder' => 'Search ...',
                    'class'       => 'nav-search-input'
                ]) .
                Html::tag('i', '', [
                    'class' => 'icon-search nav-search-icon'
                ])
            , ['class' => 'input-icon']);
        // echo '    <span class="input-icon">
        //         <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
        //         <i class="icon-search nav-search-icon"></i> </span>';
        $form->end();
    }

    protected function getTemplate()
    {
        return <<<EOT
<form class="form-search">
    <span class="input-icon">
        <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
        <i class="icon-search nav-search-icon"></i> </span>
</form>
EOT;
    }
}
