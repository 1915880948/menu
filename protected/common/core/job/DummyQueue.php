<?php
/**
 * @category DummyQueue
 * @author   gouki <gouki.xiao@gmail.com>
 * @created 16/6/7 00:16
 * @since
 */
namespace common\core\job;

use yii\base\Component;
use yii\queue\QueueInterface;

/**
 * Class DummyQueue
 * @package common\core\job
 */
class DummyQueue extends Component implements QueueInterface
{
    /**
     * @param mixed $payload
     * @param string $queue
     * @param int $delay
     * @return mixed
     */
    public function push($payload, $queue, $delay = 0)
    {
    }

    /**
     * @param string $queue
     * @return mixed
     */
    public function pop($queue)
    {
    }

    /**
     * @param string $queue
     * @return mixed
     */
    public function purge($queue)
    {
    }

    /**
     * @param array $message
     * @param int $delay
     * @return mixed
     */
    public function release(array $message, $delay = 0)
    {
    }

    /**
     * @param array $message
     * @return mixed
     */
    public function delete(array $message)
    {
    }
}
