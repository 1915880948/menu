<?php
/**
 * @category Generator
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/3/5 14:50
 * @since
 */
namespace console\modules\tools\generators\search;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Schema;
use console\modules\tools\components\CodeFile;
use yii\helpers\Inflector;

/**
 * Generates CRUD
 *
 * @property array $columnNames Model column names. This property is read-only.
 * @property string $controllerID The controller ID (without the module ID prefix). This property is
 * read-only.
 * @property array $searchAttributes Searchable attributes. This property is read-only.
 * @property boolean|\yii\db\TableSchema $tableSchema This property is read-only.
 * @property string $viewPath The controller view path. This property is read-only.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Generator extends \console\modules\tools\components\Generator
{
    public $modelNs;
    public $searchNs;
    //设置是否清除Model的prefix
    public $modelPrefixClean = false;
    public $modelPrefix      = "Tbl";
    //Search Class的prefix
    public $searchClassPrefix;

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'SearchModel Generator';
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return '自动生成Model生成简单的SearchModel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['modelNs', 'searchClassPrefix', 'modelPrefix'], 'filter', 'filter' => 'trim'],
            [['modelNs', 'searchNs'], 'required'],
            [['enableI18N'], 'boolean'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'modelNs'  => 'Model Namespace',
            'searchNs' => 'SearchModel Namespace',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function hints()
    {
        return array_merge(parent::hints(), [
            'modelClass'       => 'This is the ActiveRecord class associated with the table that CRUD will be built upon.
                You should provide a fully qualified class name, e.g., <code>application\models\Post</code>.',
            'searchModelClass' => 'This is the name of the search model class to be generated. You should provide a fully
                qualified namespaced class name, e.g., <code>application\models\PostSearch</code>.',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function stickyAttributes()
    {
        return array_merge(parent::stickyAttributes(), ['baseControllerClass', 'indexWidgetType']);
    }

    /**
     * @inheritdoc
     */
    public function generate()
    {
        $modelNsPath = Yii::getAlias('@' . str_replace('\\', '/', $this->modelNs));
        $files = [];
        foreach(glob($modelNsPath . "/*.php") as $modelFilename){
            $modelClassName = basename($modelFilename, '.php');
            $searchClassName = $this->generateSearchClassName($modelClassName);
            $params = [
                'modelClassName'  => $this->modelNs . "\\" . $modelClassName,
                'searchClassName' => $this->searchNs . "\\" . $searchClassName,
            ];

            $files[] = new CodeFile(
                Yii::getAlias('@' . str_replace('\\', '/', $this->searchNs)) . '/' . $searchClassName . '.php',
                $this->render('search.php', $params)
            );
        }

        return $files;
    }

    public function generateSearchClassName($modelClassName)
    {
        if($this->modelPrefixClean){
            $modelClassName = str_replace($this->modelPrefix, "", $modelClassName);
        }
        if($this->searchClassPrefix){
            $modelClassName = ucfirst($this->searchClassPrefix) . $modelClassName;
        }

        return $modelClassName;
    }

    /**
     * Generates column format
     * @param \yii\db\ColumnSchema $column
     * @return string
     */
    public function generateColumnFormat($column)
    {
        if($column->phpType === 'boolean'){
            return 'boolean';
        } elseif($column->type === 'text'){
            return 'ntext';
        } elseif(stripos($column->name, 'time') !== false && $column->phpType === 'integer'){
            return 'datetime';
        } elseif(stripos($column->name, 'email') !== false){
            return 'email';
        } elseif(stripos($column->name, 'url') !== false){
            return 'url';
        } else{
            return 'text';
        }
    }

    /**
     * Generates validation rules for the search model.
     * @return array the generated validation rules
     */
    public function generateSearchRules($modelClass)
    {
        if(($table = $this->getTableSchema($modelClass)) === false){
            return ["[['" . implode("', '", $this->getColumnNames($modelClass)) . "'], 'safe']"];
        }
        $types = [];
        foreach($table->columns as $column){
            switch($column->type){
                case Schema::TYPE_SMALLINT:
                case Schema::TYPE_INTEGER:
                case Schema::TYPE_BIGINT:
                    $types['integer'][] = $column->name;
                    break;
                case Schema::TYPE_BOOLEAN:
                    $types['boolean'][] = $column->name;
                    break;
                case Schema::TYPE_FLOAT:
                case Schema::TYPE_DOUBLE:
                case Schema::TYPE_DECIMAL:
                case Schema::TYPE_MONEY:
                    $types['number'][] = $column->name;
                    break;
                case Schema::TYPE_DATE:
                case Schema::TYPE_TIME:
                case Schema::TYPE_DATETIME:
                case Schema::TYPE_TIMESTAMP:
                default:
                    $types['safe'][] = $column->name;
                    break;
            }
        }

        $rules = [];
        foreach($types as $type => $columns){
            $rules[] = "[['" . implode("', '", $columns) . "'], '$type']";
        }

        return $rules;
    }

    /**
     * @return array searchable attributes
     */
    public function getSearchAttributes($modelClass)
    {
        return $this->getColumnNames($modelClass);
    }

    /**
     * Generates the attribute labels for the search model.
     * @return array the generated attribute labels (name => label)
     */
    public function generateSearchLabels($modelClass)
    {
        /* @var $model \yii\base\Model */
        $model = new $modelClass();
        $attributeLabels = $model->attributeLabels();
        $labels = [];
        foreach($this->getColumnNames($modelClass) as $name){
            if(isset($attributeLabels[$name])){
                $labels[$name] = $attributeLabels[$name];
            } else{
                if(!strcasecmp($name, 'id')){
                    $labels[$name] = 'ID';
                } else{
                    $label = Inflector::camel2words($name);
                    if(!empty($label) && substr_compare($label, ' id', -3, 3, true) === 0){
                        $label = substr($label, 0, -3) . ' ID';
                    }
                    $labels[$name] = $label;
                }
            }
        }

        return $labels;
    }

    /**
     * Generates search conditions
     * @return array
     */
    public function generateSearchConditions($modelClass)
    {
        $columns = [];
        if(($table = $this->getTableSchema($modelClass)) === false){
            $class = $modelClass;
            /* @var $model \yii\base\Model */
            $model = new $class();
            foreach($model->attributes() as $attribute){
                $columns[$attribute] = 'unknown';
            }
        } else{
            foreach($table->columns as $column){
                $columns[$column->name] = $column->type;
            }
        }

        $likeConditions = [];
        $hashConditions = [];
        foreach($columns as $column => $type){
            switch($type){
                case Schema::TYPE_SMALLINT:
                case Schema::TYPE_INTEGER:
                case Schema::TYPE_BIGINT:
                case Schema::TYPE_BOOLEAN:
                case Schema::TYPE_FLOAT:
                case Schema::TYPE_DOUBLE:
                case Schema::TYPE_DECIMAL:
                case Schema::TYPE_MONEY:
                case Schema::TYPE_DATE:
                case Schema::TYPE_TIME:
                case Schema::TYPE_DATETIME:
                case Schema::TYPE_TIMESTAMP:
                    $hashConditions[] = "'{$column}' => \$this->{$column},";
                    break;
                default:
                    $likeConditions[] = "->andFilterWhere(['like', '{$column}', \$this->{$column}])";
                    break;
            }
        }

        $conditions = [];
        if(!empty($hashConditions)){
            $conditions[] = "\$query->andFilterWhere([\n"
                            . str_repeat(' ', 12) . implode("\n" . str_repeat(' ', 12), $hashConditions)
                            . "\n" . str_repeat(' ', 8) . "]);\n";
        }
        if(!empty($likeConditions)){
            $conditions[] = "\$query" . implode("\n" . str_repeat(' ', 12), $likeConditions) . ";\n";
        }

        return $conditions;
    }

    /**
     * Generates URL parameters
     * @return string
     */
    public function generateUrlParams($modelClass)
    {
        /* @var $class ActiveRecord */
        $class = $modelClass;
        $pks = $class::primaryKey();
        if(count($pks) === 1){
            if(is_subclass_of($class, 'yii\mongodb\ActiveRecord')){
                return "'id' => (string)\$model->{$pks[0]}";
            } else{
                return "'id' => \$model->{$pks[0]}";
            }
        } else{
            $params = [];
            foreach($pks as $pk){
                if(is_subclass_of($class, 'yii\mongodb\ActiveRecord')){
                    $params[] = "'$pk' => (string)\$model->$pk";
                } else{
                    $params[] = "'$pk' => \$model->$pk";
                }
            }

            return implode(', ', $params);
        }
    }

    /**
     * Generates action parameters
     * @return string
     */
    public function generateActionParams()
    {
        /* @var $class ActiveRecord */
        $class = $this->modelClass;
        $pks = $class::primaryKey();
        if(count($pks) === 1){
            return '$id';
        } else{
            return '$' . implode(', $', $pks);
        }
    }

    /**
     * Returns table schema for current model class or false if it is not an active record
     * @return boolean|\yii\db\TableSchema
     */
    public function getTableSchema($modelClass)
    {
        /* @var $class ActiveRecord */
        $class = $modelClass;
        if(is_subclass_of($class, 'yii\db\ActiveRecord')){
            return $class::getTableSchema();
        } else{
            return false;
        }
    }

    /**
     * @return array model column names
     */
    public function getColumnNames($modelClass)
    {
        /* @var $class ActiveRecord */
        $class = $modelClass;
        if(is_subclass_of($class, 'yii\db\ActiveRecord')){
            return $class::getTableSchema()->getColumnNames();
        } else{
            /* @var $model \yii\base\Model */
            $model = new $class();

            return $model->attributes();
        }
    }
}
