<?php
/**
 * @category PageHeader
 * @author   gouki <gouki.xiao@gmail.com>
 * @created  15/3/27 下午12:54
 * @since
 */
namespace common\assets\ace;

use yii\bootstrap\Widget;

/**
 * Class PageHeader
 * @package mobiadmin\widgets
 */
class PageHeader extends Widget
{
    public    $title         = '';
    public    $pageheader    = '';
    protected $noTitleLayout = '<div class="page-header"><h1>{pageheader}</h1></div>';
    protected $layout        = '<div class="page-header"><h1>{pageheader} <small><i class="icon-double-angle-right"></i> {title}</small></h1></div>';

    public function run()
    {
        if(!$this->pageheader){
            return;
        }
        if(!$this->title){
            $layout = $this->noTitleLayout;
        } else{
            $layout = $this->layout;
        }
        return str_replace(['{pageheader}', '{title}'], [$this->pageheader, $this->title], $layout);
    }
    //}
}
