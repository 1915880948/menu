<?php
/**
 * @category TreeHelper
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/5/3 20:59
 * @since
 */
namespace qiqi\helper;

use qiqi\helper\base\InstanceTrait;
use yii\base\Object;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Class TreeHelper
 * @package app\common\base
 */
class TreeHelper extends Object
{
    use InstanceTrait;
    /** @var  ActiveQuery */
    public $model;
    public $status = null;
    public $mainId = 'id';
    public $parentId = 'pid';
    public $ordinal = 'ordinal';
    public $sorttype = SORT_ASC;
    /**
     * @var
     */
    protected $datas = [];
    /**
     * @var string menuLabelTemplate
     */
    public $menuLabelTemplate = '<i class="%s"></i><span class="menu-text"> %s </span><b class="arrow icon-angle-down"></b>';
    public $menuTextLabelTemplate = '<i class="%s"></i><span class="menu-text"> %s </span> ';

    public function toMenuArray()
    {
        $menus = [];
        $trees = $this->_tree();
        foreach($trees as $tree){
            $items = [];
            $_tmp = [
                'label'   => vsprintf($items ? $this->menuLabelTemplate : $this->menuTextLabelTemplate, [
                    isset($tree['icon']) ? $tree['icon'] : '',
                    $tree['name']
                ]),
                'encode'  => false,
                'options' => ['class' => '',],
            ];
            foreach($tree['sub'] as $sub){
                if(!isset($sub['action']) || !$sub['action']){
                    $sub['action'] = '#';
                }
                $items[] = [
                    'label' => $sub['name'],
                    'url'   => is_string($sub['action']) ? [$sub['action']] : $sub['action'],
                ];
            }
            if(!$items && $tree['action']){
                $_tmp['url'] = is_string($tree['action']) ? [$tree['action']] : $tree['action'];
            } else{
                $_tmp['items'] = $items;
            }
            $menus[] = $_tmp;
        }

        return $menus;
    }

    public function init()
    {
    }

    public function getQuery()
    {
        $this->model->andFilterWhere(['status' => $this->status]);
        if($this->ordinal){
            $this->model->orderBy([$this->ordinal => $this->sorttype]);
        }
        return $this->model;
    }

    /**
     * @return array|static[]
     */
    public function getDatas()
    {
        if(!$this->datas){//从大到小
            $this->datas = $this->getQuery()
                                ->all();
        }

        return $this->datas;
    }

    /**
     * 强制赋值
     * @param $datas
     */
    public function setDatas($datas)
    {
        $this->datas = $datas;
        return $this;
    }

    public function tree()
    {
        return $this->_tree();
    }

    public function toDropdown($deep = false)
    {
        $treedata = $this->_tree();
        $results = [];
        foreach($treedata as $id => $data){
            $results[$id] = ($deep == true ? "|—" : "") . $data['name'];
            if(isset($data['sub'])){
                foreach($data['sub'] as $subId => $subData){
                    $results[$subId] = ($deep == true ? "|——" : "") . $subData['name'];
                }
            }
        }
        return $results;
    }

    private function _tree()
    {
        $menus = $this->getDatas();
        $_result = [];
        foreach($menus as $menu){
            $menu = $menu instanceof ActiveRecord ? $menu->getAttributes() : $menu;

            if($menu[$this->parentId] == 0){
                if(!isset($_result[$menu[$this->mainId]])){
                    $_result[$menu[$this->mainId]] = $menu;
                    $_result[$menu[$this->mainId]]['sub'] = [];
                } else{
                    $_result[$menu[$this->mainId]] = ArrayHelper::merge($_result[$menu[$this->mainId]], $menu);
                }
            } else{
                $_result[$menu[$this->parentId]]['sub'][$menu[$this->mainId]] = $menu;
            }
        }
        $out = [];
        foreach($_result as $pid => $_menus){
            $out[$pid] = $_menus;
        }

        usort($out, function($a, $b) {
            return (isset($a['ordinal']) && isset($b['ordinal']) && $a['ordinal'] > $b['ordinal']) ? 1 : 0;
        });

        return $out;
    }
}
