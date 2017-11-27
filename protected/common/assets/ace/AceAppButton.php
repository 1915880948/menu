<?php
/**
 * @category AceAppButton
 * @author   gouki <gouki.xiao@gmail.com>
 * @created  15/4/1 上午12:08
 * @since
 */
namespace common\assets\ace;

use yii\bootstrap\Widget;
use yii\helpers\Url;

/**
 * Class AceAppButton
 * @package mobiadmin\widgets
 */
class AceAppButton extends Widget
{
    public $url = '###';
    public $clientOptions = [ 'class' => 'btn btn-app btn-yellow btn-xs' ];
    /**
     * @var string
     */
    public $icon = '';
    public $iconOptions = [ 'class' => 'icon-print bigger-160' ];
    /**
     * @var numer
     */
    public $number;
    public $numberOptions = [ 'class' => 'line-height-1 bigger-170 blue' ];
    /**
     * @var string
     */
    public $title = '';
    public $titleOptions = [ 'class' => 'line-height-1 smaller-90' ];
    public $titleLayout = '{number}{span}{icon}{title}{/span}';
    /**
     * @var int
     */
    public $badge = 0;
    public $badgeOptions = [ 'class' => 'badge badge-pink' ];
    protected $template = '<a href="{url}" class="{class}">{title}{badge}</a>';

    public function run()
    {
        //return<span class="btn btn-app btn-sm btn-light no-hover"> <span class="line-height-1 bigger-170 blue"> 1,411 </span> <br>
        // <span class="line-height-1 smaller-90"> Views </span> </span>
        /**
         * set title
         */
        return str_replace( [ '{url}', '{class}', '{title}', '{badge}' ],
            [ $this->getUrl(), $this->clientOptions['class'], $this->getTitle(), $this->getBadge() ], $this->template );
    }

    public function getUrl()
    {
        if ($this->url != '###') {
            $this->url = Url::to( [ $this->url ] );
        }
        return $this->url;
    }

    protected function getTitle()
    {
        return str_replace( [ '{span}', '{icon}', '{title}', '{/span}', '{number}' ], [
            ( !$this->icon ? "<span class='{$this->titleOptions['class']}'>" : "" ),
            ( $this->icon ? "<i class='{$this->iconOptions['class']}'></i>" : "" ),
            $this->title,
            ( !$this->icon ? '</span>' : "" ),
            $this->number !== null ? sprintf( "<span class='%s'>%s</span><br/>", $this->numberOptions['class'], number_format( $this->number ) ) : ""
        ], $this->titleLayout );
    }

    protected function getBadge()
    {
        if ( !$this->badge) {
            return '';
        }
        return str_replace( [ '{class}', '{badge}' ], [ $this->badgeOptions['class'], $this->badge ], '<span class="{class}>{badge}</span>' );
    }
}
