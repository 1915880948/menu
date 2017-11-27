<?php
/**
 * @category Generator
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/3/6 11:37
 * @since
 */
namespace console\modules\tools\generators\rest;

use Yii;
use console\modules\tools\components\CodeFile;

/**
 * Class Generator
 * @package console\modules\tools\generators\rest
 */
class Generator extends \console\modules\tools\components\Generator
{
    /**
     * 定义modelNs,以便自动获取Restful的ModelClass
     */
    public $modelNs;
    public $searchNs;
    /**
     * controller Ns
     */
    public $controllerNs;
    public $baseControllerClass ;
    public $cleanModelPrefix = false;
    public $modelPrefix      = 'Tbl';
    /**
     * @var bool 是否支持搜索
     */
    public $generateSearch = false;

    /**
     * @return boolean
     */
    public function isGenerateSearch()
    {
        return $this->generateSearch;
    }

    /**
     * @param boolean $generateSearch
     */
    public function setGenerateSearch($generateSearch)
    {
        $this->generateSearch = $generateSearch;
    }

    public function getName()
    {
        return "Restful Controller Generate";
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['modelNs', 'searchNs', 'controllerNs'], 'filter', 'filter' => 'trim'],
            [['modelNs', 'searchNs', 'controllerNs'], 'required'],
            [['enableI18N'], 'boolean'],
        ]);
    }

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

    /**
     * @inheritdoc
     */
    public function stickyAttributes()
    {
        return array_merge(parent::stickyAttributes(), ['baseControllerClass', 'indexWidgetType']);
    }

    public function getControllerNamespace()
    {
        return $this->controllerNs;
    }
}
