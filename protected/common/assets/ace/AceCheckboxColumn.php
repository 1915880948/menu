<?php
/**
 * @category AceCheckboxColumn
 * @author   gouki <gouki.xiao@gmail.com>
 * @created  15/3/31 下午1:49
 * @since
 */
namespace common\assets\ace;

use yii\grid\CheckboxColumn;
use yii\helpers\Html;

/**
 * Class AceCheckboxColumn
 * @package mobiadmin\widgets
 */
class AceCheckboxColumn extends CheckboxColumn
{
    protected function renderHeaderCellContent()
    {
        $name = rtrim( $this->name, '[]' ) . '_all';
        $id = $this->grid->options['id'];
        $options = json_encode( [
            'name'     => $this->name,
            'multiple' => $this->multiple,
            'checkAll' => $name,
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
        $this->grid->getView()->registerJs( "jQuery('#$id').yiiGridView('setSelectionColumn', $options);" );
        if ($this->header !== null || !$this->multiple) {
            $parentHeaderCellContent = parent::renderHeaderCellContent();
        }else {
            $parentHeaderCellContent = Html::checkBox( $name, false, [ 'class' => 'select-on-check-all ace' ] );
        }
        return '<label>' . $parentHeaderCellContent . '<span class="lbl"></span></label>';
    }

    protected function renderDataCellContent( $model, $key, $index )
    {
        $parentDataCellContent = parent::renderDataCellContent( $model, $key, $index );
        return '<label>' . $parentDataCellContent . '<span class="lbl"></span></label>';
    }
}
