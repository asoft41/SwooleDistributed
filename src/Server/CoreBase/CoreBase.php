<?php
/**
 * Created by PhpStorm.
 * User: zhangjincheng
 * Date: 16-7-15
 * Time: 下午1:24
 */

namespace Server\CoreBase;


use Monolog\Logger;
use Noodlehaus\Config;
use Server\Pack\IPack;

class CoreBase extends Child
{
    /**
     * 销毁标志
     * @var bool
     */
    public $is_destroy = false;

    /**
     * @var Loader
     */
    public $loader;
    /**
     * @var Logger
     */
    public $logger;
    /**
     * @var swoole_server
     */
    public $server;
    /**
     * @var Config
     */
    public $config;
    /**
     * @var IPack
     */
    public $pack;
    /**
     * @var \Server\Asyn\Redis\RedisAsynPool
     */
    public $redis_pool;
    /**
     * @var \Server\Asyn\Mysql\MysqlAsynPool
     */
    public $mysql_pool;

    /**
     * Task constructor.
     */
    public function __construct()
    {
        if (!empty(get_instance())) {
            $this->loader = get_instance()->loader;
            $this->logger = get_instance()->log;
            $this->server = get_instance()->server;
            $this->config = get_instance()->config;
            $this->pack = get_instance()->pack;
            $this->redis_pool = get_instance()->redis_pool;
            $this->mysql_pool = get_instance()->mysql_pool;
        }
    }

    /**
     * 销毁，解除引用
     */
    public function destroy()
    {
        parent::destroy();
        $this->is_destroy = true;
    }

    /**
     * 对象复用
     */
    public function reUse()
    {
        $this->is_destroy = false;
    }

    /**
     * 打印日志
     * @param $message
     * @param int $level
     */
    protected function log($message, $level = Logger::DEBUG)
    {
        $this->logger->addRecord($level, $message, $this->getContext());
    }
}