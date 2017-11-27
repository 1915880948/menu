<?php
/**
 * @category AceNav
 * @author   gouki <gouki.xiao@gmail.com>
 * @created  15/3/25 下午5:22
 * @since
 */
namespace common\assets\ace;

use yii\bootstrap\Nav;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Class AceNav
 * @package mobiadmin\widgets
 */
class AceNav extends Nav
{
    public $activateParents = true;
    public $activeId = 0;
    /**
     * Renders a widget's item.
     * @param string|array $item the item to render.
     * @return string the rendering result.
     * @throws \InvalidConfigException
     */
    public function renderItem( $item )
    {
        if (is_string( $item )) {
            return $item;
        }
        if ( !isset( $item['label'] )) {
            throw new \InvalidArgumentException( "The 'label' option is required." );
        }
        $encodeLabel = isset( $item['encode'] ) ? $item['encode'] : $this->encodeLabels;
        $label = $encodeLabel ? Html::encode( $item['label'] ) : $item['label'];
        $options = ArrayHelper::getValue( $item, 'options', [ ] );
        $items = ArrayHelper::getValue( $item, 'items' );
        $url = ArrayHelper::getValue( $item, 'url', '#' );
        $linkOptions = ArrayHelper::getValue( $item, 'linkOptions', [ ] );
        if (isset( $item['active'] )) {
            $active = ArrayHelper::remove( $item, 'active', false );
        }else {
            $active = $this->isItemActive( $item );
        }
        if ($items !== null) {
            //$linkOptions['data-toggle'] = 'dropdown';
            //Html::addCssClass( $options, 'dropdown' );
            Html::addCssClass( $linkOptions, 'dropdown-toggle' );
            if (is_array( $items )) {
                if ($this->activateItems) {
                    $items = $this->isChildActive( $items, $active );
                }
                $items = $this->renderDropdown( $items, $item );
            }
        }
        if ($this->activateItems && $active) {
            Html::addCssClass( $options, 'active' );
            Html::addCssClass( $options, 'open' );
        }

        return Html::tag( 'li', Html::a( $label, $url, $linkOptions ) . $items, $options );
    }

    /**
     * Renders the given items as a dropdown.
     * This method is called to create sub-menus.
     * @param array $items      the given items. Please refer to [[Dropdown::items]] for the array structure.
     * @param array $parentItem the parent item information. Please refer to [[items]] for the structure of this array.
     * @return string the rendering result.
     * @since 2.0.1
     */
    protected function renderDropdown( $items, $parentItem )
    {
        return AceDropdown::widget( [
            'items'         => $items,
            'encodeLabels'  => $this->encodeLabels,
            'clientOptions' => false,
            'view'          => $this->getView(),
        ] );
    }
}
