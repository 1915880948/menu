<?php
/**
 * @category SiteController
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/6/16 22:14
 * @since
 */
namespace application\web\thumb\controllers;

use PHPThumb\GD;
use qiqi\helper\log\FileLogHelper;
use yii\helpers\Url;
use yii\log\Logger;
use yii\web\Controller;

/**
 * Class SiteController
 * @package thumb\controllers
 */
class SiteController extends Controller
{
    public $allowVirtualPath = true;
    public $defaultImage     = 'assets/error.png';
    public $default404Image  = 'assets/404.jpg';
    public $debug            = false;
    /**
     * @var array 如果后缀名对应文件不存在，按这个顺序查找
     */
    public $extSequence = ['png', 'jpg', 'gif'];
    /**
     * 图片操作
     * @var array
     */
    public $imageActions = [];
    /**
     * 切图的时候是否检测头部，避免切的时候头被切掉
     * @var bool
     */
    public $cropWithFaceDetector = false;
    /**
     * 不含后缀的文件名，因为后缀名允许变化
     */
    public $baseFileName;
    public $baseFileExtension;
    public $adjustOrientation = true;

    public function actionError()
    {
        $paths = explode("/", \Yii::$app->getRequest()->getPathInfo());
        $pathDeepth = $this->allowVirtualPath === true ? 3 : 2;
        if(count($paths) < $pathDeepth){
            return $this->redirectDefaultImage();
        }
        if($this->allowVirtualPath === true){
            list($virtualPath, $module, $filename) = explode("/", \Yii::$app->getRequest()->getPathInfo(), 3);
        } else{
            list($module, $filename) = explode("/", \Yii::$app->getRequest()->getPathInfo(), 2);
        }
        $configs = $this->getDefaultConfig();
        if(!isset($configs[$module]) || !$configs[$module]){
            \Yii::getLogger()->log("Thumb Module [{$module}] does not exists;", Logger::LEVEL_ERROR);
            return $this->redirect404Image();
        }
        $config = $configs[$module];
        $this->debug = isset($config['debug']) ? (bool) $config['debug'] : false;
        $sourcePath = $config['source_path'];
        $savedPath = \Yii::getAlias("@webroot/") . \Yii::$app->getRequest()->getPathInfo();
        if(!is_dir(dirname($savedPath))){//生成文件目录
            mkdir(dirname($savedPath), 0766, true);
        }
        $pathinfo = pathinfo($filename);
        $fileInfo = $this->parseFileInfo($pathinfo);
        $this->baseFileExtension = strtolower($pathinfo['extension']);
        if(!$fileInfo){//这是没有附加属性，代表这是原图
            $fileRealPath = rtrim($sourcePath, "/") . "/" . $filename;
            if(!file_exists($fileRealPath)){
                return $this->redirect404Image();
            }
        } else{
            /**
             * 开始处理，用指定后缀处理
             */

            $filePrefix = sprintf("%s/%s/%s.", rtrim($sourcePath, "/"), $pathinfo['dirname'], $this->baseFileName);
            if(!is_dir(dirname($filePrefix))){//如果目录不存在
                return $this->redirect404Image();
            }
            $globs = glob($filePrefix . "*");
            if(!$globs){
                return $this->redirect404Image();
            }
            /**
             * 获取第一个文件
             */
            $fileRealPath = array_shift($globs);
        }
        $thumb = new GD($fileRealPath);

        //设置最大宽高值
        $thumb->setMaxWidth($config['max_width'])->setMaxHeight($config['max_height']);
        $imageDimensions = $thumb->getCurrentDimensions();
        /**
         * c_fill,f_gray,h_100,w_100,q_60,r_180,w_150,p_50
         * c_fill,,h_100,w_100,p_50
         */
        if(isset($fileInfo['p'])){//如果有按比例缩略
            unset($fileInfo['w'], $fileInfo['h']);
            $thumb->resizePercent($fileInfo['p']);
        }
        if($this->baseFileExtension == "jpg" && isset($fileInfo['q']) && $fileInfo['q'] <= 100){
            $thumb->setOptions(['jpegQuality' => $fileInfo['q']]);
        }
        if(isset($fileInfo['f'])){
            $thumb->updateGrayImage();
        }
        if(isset($fileInfo['r'])){
            if(is_numeric($fileInfo['r'])){
                $thumb->rotateImageNDegrees($fileInfo['r']);
            }
            if($fileInfo['r'] == "auto"){
                $thumb->adjustOrientation();
            }
            //重新处理过了
            $imageDimensions = $thumb->getCurrentDimensions();
        }
        //判断是横竖图
        $isLandscape = $imageDimensions['width'] > $imageDimensions['height'];

        if(isset($fileInfo['c'])){
            $cropType = $fileInfo['c'];
            if($cropType == "fill"){
                // $thumb->ad($thumb->getMaxWidth(),$thumb->getMaxHeight());
                if(isset($fileInfo['w'])&&isset($fileInfo['h'])){
                    $thumb->setOptions(['resizeUp'=>true])->adaptiveResizeQuadrant($fileInfo['w'], $fileInfo['h']);
                } elseif(isset($fileInfo['w'])){
                    if(!isset($fileInfo['h'])){
                        $fileInfo['h'] = $fileInfo['w'] / ($imageDimensions['width'] / $imageDimensions['height']);
                    }
                    $thumb->adaptiveResizeQuadrant($fileInfo['w'], isset($fileInfo['h']) ? $fileInfo['h'] : null);
                } elseif(isset($fileInfo['h'])){//没有设置宽度
                    $fileInfo['w'] = $fileInfo['h'] * ($imageDimensions['width'] / $imageDimensions['height']);
                    $thumb->adaptiveResizeQuadrant($fileInfo['w'], $fileInfo['h']);
                } else{
                    if($imageDimensions['width'] > $thumb->getMaxHeight() || $imageDimensions['height'] > $thumb->getMaxHeight()){
                        if($isLandscape){
                            $w = $thumb->getMaxWidth();
                            $h = $w / ($imageDimensions['width'] / $imageDimensions['height']);
                        } else{
                            $h = $thumb->getMaxHeight();
                            $w = $h * ($imageDimensions['width'] / $imageDimensions['height']);
                        }
                        $thumb->adaptiveResize($w, $h);
                    }
                }
            }
            if($cropType == "face"){//检测脸部，未完成

            }
        } else{
            if(isset($fileInfo['w']) || isset($fileInfo['h'])){
                if(isset($fileInfo['w']) && !isset($fileInfo['h'])){
                    $fileInfo['h'] = $fileInfo['h'] / ($imageDimensions['width'] / $imageDimensions['height']);
                } else{//elseif(isset($fileInfo['h']) && !isset($fileInfo['w'])){
                    $fileInfo['w'] = $fileInfo['h'] * ($imageDimensions['width'] / $imageDimensions['height']);
                }
                $thumb->adaptiveResize($fileInfo['w'], $fileInfo['h']);
            }
        }

        if($thumb->save($savedPath)){
            $this->redirectImage();
        }
        $this->redirect404Image();
    }

    /**
     * abc,c_fill,f_gray,h_100,w_100,q_60,r_180,w_150,p_50.jpg
     * @param $pathinfo
     */
    protected function parseFileInfo($pathinfo)
    {
        $baseFileName = $pathinfo['filename'];
        $fileInfos = explode(",", $baseFileName);
        $this->baseFileName = array_shift($fileInfos);
        $waitActions = [];
        foreach($fileInfos as $info){
            list($k, $v) = explode("_", $info);
            $waitActions[$k] = $v;
        }
        return $waitActions;
    }

    protected function redirectImage()
    {
        $this->redirect(Url::to(\Yii::getAlias('@web/').\Yii::$app->request->pathInfo,true));
        \Yii::$app->end(200);
    }

    protected function redirectDefaultImage()
    {
        $this->redirect(Url::to("@web/{$this->defaultImage}", true));
        \Yii::$app->end(200);
    }

    protected function redirect404Image()
    {
        $this->redirect(Url::to("@web/{$this->default404Image}", true));
        \Yii::$app->end(200);
    }

    protected function getDefaultConfig()
    {
        return include \Yii::getAlias("@webroot/config.default.php");
    }

    protected function writeLog($log)
    {
        if($this->debug === true){
            FileLogHelper::xlog($log, 'thumb');
        }
    }
}
