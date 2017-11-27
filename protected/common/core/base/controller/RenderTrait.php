<?php
/**
 * @category RenderTrait
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 2017/10/1 11:40
 * @since
 */

namespace common\core\base\controller;

/**
 * 专为模块进行默认输出的时候使用
 * Trait RenderTrait
 * @package common\core\base\controller
 */
trait RenderTrait
{
    public function run()
    {
        return $this->render();
    }
}
