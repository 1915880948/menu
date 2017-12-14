<?php
namespace application\web\admin\controllers;

use common\core\base\BaseController;
use common\core\base\controller\ActionsTrait;

class BrowserController extends BaseController {
    public $enableCsrfValidation = false;
    use ActionsTrait;
}