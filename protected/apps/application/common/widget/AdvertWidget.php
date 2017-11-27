<?php
/**
 * @category AdvertWidget
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/5/14 08:24
 * @since
 */
namespace application\common\widget;

use application\models\base\AdvertDetail;
use application\models\data\Advert;
use yii\base\Exception;
use yii\bootstrap\Widget;

/**
 * Class AdvertWidget
 * @package application\common\widget
 */
class AdvertWidget extends Widget
{
    public $advertId;
    protected $datas;

    public function init()
    {
        if(!$this->advertId){
            throw new Exception('缺少advertId参数');
        }
        $this->datas = $this->getAdvertDatas();
    }

    public function getDatas()
    {
        return $this->datas;
    }

    protected function getAdvertDatas()
    {
        $advertTypes = Advert::getInstance()
                             ->getTypeInfo($this->advertId);
        return AdvertDetail::find()
                           ->andWhere(['adid' => $this->advertId])
                           ->orderBy(['ordinal' => SORT_ASC])
                           ->limit($advertTypes['number'])
                           ->asArray()
                           ->all();
    }

    protected function parseSingleData($data)
    {
    }
}
