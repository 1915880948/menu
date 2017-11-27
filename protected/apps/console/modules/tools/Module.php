<?php
/**
 * @category Module
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/3/5 14:23
 * @since
 */
namespace console\modules\tools;

/**
 * Class Module
 * @package console\modules\tools
 */

use console\modules\tools\components\GenerateController;
use console\modules\tools\components\Generator;
use Yii;
use yii\base\BootstrapInterface;

/**
 * This is the main module class for the Gii module.
 *
 * To use Gii, include it as a module in the application configuration like the following:
 *
 * ~~~
 * return [
 *     'bootstrap' => ['tools'],
 *     'modules' => [
 *         'tools' => ['class' => 'console\modules\tools\Module'],
 *     ],
 * ]
 * ~~~
 *
 * Because Gii generates new code files on the server, you should only use it on your own
 * development machine. To prevent other people from using this module, by default, Gii
 * can only be accessed by localhost. You may configure its [[allowedIPs]] property if
 * you want to make it accessible on other machines.
 *
 * With the above configuration, you will be able to access GiiModule in your browser using
 * the URL `http://localhost/path/to/index.php?r=gii`
 *
 * If your application enables [[\yii\web\UrlManager::enablePrettyUrl|pretty URLs]],
 * you can then access Gii via URL: `http://localhost/path/to/index.php/gii`
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'console\modules\tools\controllers';
    /**
     * @var array|Generator[] a list of generator configurations or instances. The array keys
     * are the generator IDs (e.g. "crud"), and the array elements are the corresponding generator
     * configurations or the instances.
     *
     * After the module is initialized, this property will become an array of generator instances
     * which are created based on the configurations previously taken by this property.
     *
     * Newly assigned generators will be merged with the [[coreGenerators()|core ones]], and the former
     * takes precedence in case when they have the same generator ID.
     */
    public $generators = [];
    /**
     * @var integer the permission to be set for newly generated code files.
     * This value will be used by PHP chmod function.
     * Defaults to 0666, meaning the file is read-writable by all users.
     */
    public $newFileMode = 0666;
    /**
     * @var integer the permission to be set for newly generated directories.
     * This value will be used by PHP chmod function.
     * Defaults to 0777, meaning the directory can be read, written and executed by all users.
     */
    public $newDirMode = 0777;

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $app->controllerMap[$this->id] = [
            'class'      => GenerateController::className(),
            'generators' => array_merge($this->coreGenerators(), $this->generators),
            'module'     => $this,
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if(!parent::beforeAction($action)){
            return false;
        }

        foreach(array_merge($this->coreGenerators(), $this->generators) as $id => $config){
            $this->generators[$id] = Yii::createObject($config);
        }

        $this->resetGlobalSettings();

        return true;
    }

    /**
     * Resets potentially incompatible global settings done in app config.
     */
    protected function resetGlobalSettings()
    {
        if(Yii::$app instanceof \yii\web\Application){
            Yii::$app->assetManager->bundles = [];
        }
    }

    /**
     * Returns the list of the core code generator configurations.
     * @return array the list of the core code generator configurations.
     */
    protected function coreGenerators()
    {
        return [
            'search' => ['class' => 'console\modules\tools\generators\search\Generator'],
            'model'  => ['class' => 'console\modules\tools\generators\model\Generator'],
            'rest'   => ['class' => 'console\modules\tools\generators\rest\Generator'],
            'basemodel' => ['class' => 'console\modules\tools\generators\basemodel\Generator'],
            // 'module' => ['class' => 'console\modules\tools\generators\module\Generator'],
        ];
    }
}

