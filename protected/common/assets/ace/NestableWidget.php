<?php
/**
 * @category NestableWidget
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 10/14/15 16:06
 * @since
 */
namespace common\assets\ace;

use common\status\BaseStatus;
use yii\bootstrap\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/**
 * Class NestableWidget
 * @package common\assets\ace
 */
class NestableWidget extends Widget
{
    public $elements;
    public $maxDeepth    = 2;
    public $elementId    = 'id';
    public $operate      = 'status';
    public $operateValue = BaseStatus::COMMON_STATUS_DISABLED;
    public $method       = 'get';
    public $confirmText  = '你确认要删除吗？如果删除，该分类下的子分类也将删除';
    /**
     * @var View
     */
    public $view;
    public $id = 'nestable';
    /**
     * @var array
     */
    public $url     = 'system/menu';
    public $sortUrl = 'system/menusort';

    public function init()
    {
        if(!$this->view){
            $this->view = $this->getView();
        }
        $this->view->registerJsFile('@webstatic/vendor/ace/assets/js/jquery.nestable.min.js', [
            'depends'  => 'yii\web\JqueryAsset',
            'position' => View::POS_END,
        ]);
        $this->view->registerJsFile('@webstatic/vendor/ace/assets/js/bootbox.min.js', [
            'depends'  => 'yii\web\JqueryAsset',
            'position' => View::POS_END,
        ]);
        $url = Url::toRoute([$this->url]);
        $sortUrl = Url::toRoute([$this->sortUrl]);
        $this->view->registerJs("var menuUrl = '{$url}',sortUrl = '{$sortUrl}';", View::POS_READY);
        $this->view->registerJs("\$(\"#nestable\").nestable({maxDepth:{$this->maxDeepth}});");
        $this->view->registerJs('
            $("#nestable").on("change",function(){
                // console.log($(".dd").nestable("serialize"));
                // console.log(JSON.stringify($(".dd").nestable("serialize")));
                $.post(sortUrl,{sort:JSON.stringify($(".dd").nestable("serialize"))},function(data){
                    // console.log(data.info);
                    bootbox.alert(data.info,function(){
                        //location.href = menuUrl;
                    });
                },"JSON");
            });
            $(".dd-handle a").on("mousedown", function(e){
				e.stopPropagation();
			});
		', View::POS_READY);
    }

    public function run()
    {
        $html = [];
        foreach($this->elements as $element){
            $html[] = $this->generateLiWithSub($element);
        }
        return Html::tag("div", $this->generateOl($html), ['id' => $this->id, 'class' => "dd"]);
    }

    protected function generateLiWithSub($element)
    {
        $data[] = $this->generateData($element['name'], $element[$this->elementId], true, $element);
        if($element['sub']){
            $tmp = [];

            foreach($element['sub'] as $sub){
                $tmp[] = $this->generateLiData($sub['name'], $sub[$this->elementId], true, $sub);
            }
            $data[] = $this->generateOl($tmp);
            /**
             *                                 <button data-action="collapse" type="button">Collapse</button>
             * <button data-action="expand" type="button" style="display: none;">Expand</button>
             */
//            $data[] = Html::button('Collapse', ['data-action' => "collapse"]);
            $data[] = Html::button('Expand', ['data-action' => "expand", 'style' => 'display:none']);
        }
        $class = "dd-item ";
        if(isset($element['status']) && $element['status'] != BaseStatus::COMMON_STATUS_ENABLED){
            //$class .= " label label-warning ";
        }
        return Html::tag("li", join("\n", $data), ['class' => $class, 'data-id' => $element[$this->elementId]]);
    }

    protected function generateData($name, $id, $operate = false, $data = null)
    {
        if(isset($data['icon'])){
            $name = Html::tag('i', '', ['class' => "icon {$data['icon']}"]) . " " . $name;
        }
        $content[] = $name;
        if($operate == true){

            $content[] = Html::tag('div', join("\n", [
                Html::a(Html::tag('i', '', ['class' => 'icon-pencil bigger-130']), Url::to([$this->url, 'id' => $id]), ['class' => 'blue']),
                Html::a(Html::tag('i', '', ['class' => 'icon-trash bigger-130']), Url::to([
                    $this->url,
                    'id'           => $id,
                    $this->operate => $this->operateValue,
                ]), ArrayHelper::merge([
                    'class' => 'red',
                ],
                    $this->method == 'post' ? [
                        'data' => ['method' => 'post', 'confirm' => $this->confirmText, 'params' => ['id' => $id, $this->operate => $this->operateValue]]
                    ] : []
                )),
            ]), ['class' => 'pull-right action-buttons']);
        }
        $class = "dd-handle ";
        if(isset($data['status']) && $data['status'] != BaseStatus::COMMON_STATUS_ENABLED){
            $class .= " label label-light textleft ";
        }
        return Html::tag("div", join("\n", $content), ['class' => $class]);
    }

    /**
     * @param $name
     * @param $id
     * @param bool|false $operate
     * @param  $data
     * @return string
     * <li class="dd-item" data-id="1">
     * <div class="dd-handle">
     * Item 1
     * <i class="pull-right bigger-130 icon-warning-sign orange2"></i>
     * </div>
     * </li>
     */
    protected function generateLiData($name, $id, $operate = false, $data = null)
    {
        return Html::tag('li', $this->generateData($name, $id, $operate, $data), ['class' => 'dd-item', 'data-id' => $id]);
    }

    protected function generateOl($items)
    {
        return Html::tag("ol", join("\n", $items), ['class' => 'dd-list']);
        //return Html::ul($items);
    }
}
