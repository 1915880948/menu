<?php
/**
 * @category AceDropdown
 * @author   gouki <gouki.xiao@gmail.com>
 * @created  15/3/25 下午6:02
 * @since
 */
namespace common\assets\ace;

use yii\bootstrap\Dropdown;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Class AceDropdown
 * @package mobiadmin\widgets
 */
class AceDropdown extends Dropdown
{
    public function init()
    {
        if ( !isset( $this->options['id'] )) {
            $this->options['id'] = $this->getId();
        }
        Html::addCssClass( $this->options, 'submenu' );
    }

    protected function renderItems( $items, $options = [ ] )
    {
        $lines = [ ];
        foreach ($items as $i => $item) {
            if (isset( $item['visible'] ) && !$item['visible']) {
                unset( $items[$i] );
                continue;
            }
            if (is_string( $item )) {
                $lines[] = $item;
                continue;
            }
            if ( !array_key_exists( 'label', $item )) {
                throw new \InvalidConfigException( "The 'label' option is required." );
            }
            $encodeLabel = isset( $item['encode'] ) ? $item['encode'] : $this->encodeLabels;
            $label = $encodeLabel ? Html::encode( $item['label'] ) : $item['label'];
            $itemOptions = ArrayHelper::getValue( $item, 'options', [ ] );
            $linkOptions = ArrayHelper::getValue( $item, 'linkOptions', [ ] );
            $linkOptions['tabindex'] = '-1';
            $url = array_key_exists( 'url', $item ) ? $item['url'] : null;
            if (empty( $item['items'] )) {
                if ($url === null) {
                    $content = $label;
                    Html::addCssClass( $itemOptions, 'dropdown-header' );
                }else {
                    $content = Html::a( $label, $url, $linkOptions );
                }
            }else {
                $submenuOptions = $options;
                unset( $submenuOptions['id'] );
                $content = Html::a( $label, $url === null ? '#' : $url, $linkOptions ) . $this->renderItems( $item['items'], $submenuOptions );
                //Html::addCssClass( $itemOptions, 'dropdown-submenu' );
                Html::addCssClass( $itemOptions, 'submenu' );
            }
            $lines[] = Html::tag( 'li', $content, $itemOptions );
        }
        return Html::tag( 'ul', implode( "\n", $lines ), $options );
    }
}
