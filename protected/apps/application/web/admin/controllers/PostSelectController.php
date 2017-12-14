<?php
namespace application\web\admin\controllers;

use application\web\admin\components\AdminBaseController;
use common\core\base\controller\ActionsTrait;

class PostSelectController extends AdminBaseController{
    public $enableCsrfValidation = false;
    use ActionsTrait;
}