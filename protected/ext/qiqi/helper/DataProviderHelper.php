<?php
/**
 * @category DataProviderHelper
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/1/24 16:27
 * @since
 */
namespace qiqi\helper;

use yii\base\Object;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\data\BaseDataProvider;
use yii\data\SqlDataProvider;

/**
 * Class DataProviderHelper
 * @package common\helper
 */
class DataProviderHelper extends Object
{
    public static function generate(BaseDataProvider $provider, $pageSize = 25, $page = null)
    {
        if($page !== null && is_numeric($page)){
            $provider->getPagination()
                     ->setPage((int) $page);
        }

        return $provider;
    }

    public static function createWithSort($query, $sort, $pageSize = 25, $page = null)
    {
        $provider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => ['pageSize' => $pageSize],
            'sort'       => $sort,
        ]);
        if($page !== null && is_numeric($page)){
            $provider->getPagination()
                     ->setPage((int) $page);
        }
        return $provider;
    }

    /**
     * @param $query
     * @param int $pageSize
     * @param null $page
     * @return ActiveDataProvider
     */
    public static function create($query, $pageSize = 25, $page = null)
    {
        $provider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => ['pageSize' => $pageSize],
        ]);
        if($page !== null && is_numeric($page)){
            $provider->getPagination()
                     ->setPage((int) $page);
        }

        return $provider;
    }

    /**
     * @param $array
     * @param int $pageSize
     * @param null $page
     * @return ArrayDataProvider
     */
    public static function arrCreate($array, $pageSize = 25, $page = null)
    {
        $provider = new ArrayDataProvider([
            'allModels'  => $array,
            'pagination' => ['pageSize' => $pageSize],
        ]);
        if($page !== null && is_numeric($page)){
            $provider->getPagination()
                     ->setPage((int) $page);
        }

        return $provider;
    }

    /**
     * 未完成
     * @param $sql
     * @param int $pageSize
     * @param null $page
     * @return SqlDataProvider
     * * $count = Yii::$app->db->createCommand('
     *     SELECT COUNT(*) FROM user WHERE status=:status
     * ', [':status' => 1])->queryScalar();
     * $dataProvider = new SqlDataProvider([
     *     'sql' => 'SELECT * FROM user WHERE status=:status',
     *     'params' => [':status' => 1],
     *     'totalCount' => $count,
     *     'sort' => [
     *         'attributes' => [
     *             'age',
     *             'name' => [
     *                 'asc' => ['first_name' => SORT_ASC, 'last_name' => SORT_ASC],
     *                 'desc' => ['first_name' => SORT_DESC, 'last_name' => SORT_DESC],
     *                 'default' => SORT_DESC,
     *                 'label' => 'Name',
     *             ],
     *         ],
     *     ],
     *     'pagination' => [
     *         'pageSize' => 20,
     *     ],
     * ]);
     */
    public static function sqlCreate($sql, $pageSize = 25, $page = null)
    {
        $provider = new SqlDataProvider([
            'sql'        => $sql,
            'pagination' => ['pageSize' => $pageSize],
        ]);
        if($page !== null && is_numeric($page)){
            $provider->getPagination()
                     ->setPage((int) $page);
        }

        return $provider;
    }
}
