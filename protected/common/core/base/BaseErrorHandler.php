<?php
/**
 * @category BaseErrorHandler
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2016/10/10 10:03
 * @since
 */
namespace common\core\base;

use Exception;
use Yii;
use yii\base\ErrorException;
use yii\base\UserException;
use yii\web\ErrorHandler;
use yii\web\HttpException;

/**
 * Class BaseErrorHandler
 * @package common\core\base
 */
class BaseErrorHandler extends ErrorHandler
{
    const ERROR_RECEIVED = __CLASS__;

    /**
     * Renders the exception.
     *
     * @param \Exception $exception the exception to be rendered.
     */
    protected function renderException($exception)
    {
        // return parent::renderException($exception);
        $response = Yii::$app->getResponse();
        $response->format = 'json';
        $response->isSent = false;
        $response->data = $this->convertExceptionToArray($exception);
        $response->setStatusCode(200);
        $response->send();
    }

    /**
     * Converts an exception into an array.
     *
     * @param \Exception $exception the exception being converted
     * @param  boolean $gotoSchema
     *
     * @return array the array representation of the exception.
     */
    protected function convertExceptionToArray($exception, $gotoSchema = true)
    {
        if(!YII_DEBUG && !$exception instanceof UserException && !$exception instanceof HttpException){
            $exception = new HttpException(200, 'There was an error at the server.');
        }
        if($exception instanceof HttpException && $exception->statusCode == 404){

        }

        $array = [
            'name' => ($exception instanceof Exception || $exception instanceof ErrorException)
                ? $exception->getName() : 'Exception',
            'info' => $exception->getMessage(),
            'code' => $exception->getCode(),
        ];
        if($exception instanceof HttpException && $exception->statusCode == 403){
            //$array['status'] = $exception->statusCode;
            $array['status'] = Schema::STATUS_NEED_LOGIN;
        }
        if(YII_DEBUG || IS_DEV_MODE){
            $array['type'] = get_class($exception);
            if(!$exception instanceof UserException){
                $array['file'] = $exception->getFile();
                $array['line'] = $exception->getLine();
                $array['stack-trace'] = explode("\n", $exception->getTraceAsString());
                if($exception instanceof \yii\db\Exception){
                    $array['error-info'] = $exception->errorInfo;
                }
            }
        }
        if(($prev = $exception->getPrevious()) !== null){
            $array['previous'] = $this->convertExceptionToArray($prev, false);
        }
        if($gotoSchema === true){
            if(isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Alibaba.Security.Heimdall') !== false){
                return $array;
            } else{
                return Schema::Failure($array);
            }
        }

        return $array;
    }
}
