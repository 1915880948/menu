<?php
/**
 * @category QSearchInstance
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2016/10/26 19:04
 * @since
 */
namespace common\core\db\base;

use qiqi\helper\base\InstanceTrait;
use qiqi\helper\DataProviderHelper;
use yii\base\InvalidParamException;
use yii\base\Object;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\validators\NumberValidator;
use yii\validators\StringValidator;

/**
 * Class QSearchInstance
 * @package common\core\db\base
 */
trait QSearchInstance
{
    public $defaultSort = [];
    /**
     * @var ActiveRecord
     */
    public $model;

    /**
     * @return ActiveRecord
     */
    public function getModel()
    {
        return $this->model;
    }

    use InstanceTrait;

    /**
     * @param mixed $model
     */
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    public function search($params, $pageSize = 25, $page = null)
    {
        $model = $this->getModel();
        if(!$model){
            throw new InvalidParamException('缺少model传入');
        }
        $integers = $strings = [];
        $attributes = $model->getAttributes();
        foreach($model->getValidators() as $validator){
            if($validator instanceof NumberValidator){
                $integers = ArrayHelper::merge($integers, $validator->attributes);
            }
            if($validator instanceof StringValidator){
                $strings = ArrayHelper::merge($strings, $validator->attributes);
            }
        }
        $query = $model::find();
        if(isset($params['or'])){
            $orWheres = $this->parseSearchConditions($params['or'], $attributes, $integers, $strings);
            unset($params['or']);

            if($orWheres){
                $orWheres = ArrayHelper::merge(['or'], $orWheres);
                $query->andFilterWhere($orWheres);
            }
        }

        if(!isset($params['and'])){
            $params['and'] = $params;
        }
        if(isset($params['and'])){
            $andWheres = $this->parseSearchConditions($params['and'], $attributes, $integers, $strings);

            if($andWheres){
                $andWheres = ArrayHelper::merge(['and'], $andWheres);
                $query->andFilterWhere($andWheres);
            }
        }
        if(!$this->defaultSort){
            $primary = $model->primaryKey();
            if($primary){
                $this->defaultSort = [$primary[0] => ['default' => SORT_DESC]];
            }
        }
        $sorts = [
            'attributes'   => array_keys($attributes),
            'defaultOrder' => $this->defaultSort
        ];

        return DataProviderHelper::createWithSort($query, $sorts, $pageSize, $page);
    }

    /**
     * @param array $defaultSort
     * @return QSearchInstance
     */
    public function setDefaultSort(array $defaultSort)
    {
        $this->defaultSort = $defaultSort;
        return $this;
    }

    /**
     * @param $params
     * @param $attributes
     * @param $integers
     * @param $strings
     * @return array
     */
    protected function parseSearchConditions($params, $attributes, $integers, $strings)
    {
        $conditions = [];
        foreach($params as $k => $value){
            if(!array_key_exists($k, $attributes)){
                continue;
            }
            if(is_array($value)){
                $conditions[] = ['in', $k, $value];
                continue;
            }
            if(in_array($k, $integers) && $value){
                $conditions[] = [$k => (int) $value];
            }
            if(in_array($k, $strings) && $value){
                $conditions[] = ['like', $k, $value];
            }
        }

        return $conditions;
    }
}
