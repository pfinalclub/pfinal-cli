<?php
/**
 * Created by PhpStorm.
 * User: nancheng
 * Date: 2019/1/23
 * Time: 10:34 PM
 * Email: Lampxiezi@163.com
 * Blog:  http://friday-go.cc/
 *
 *                      _ooOoo_
 *                     o8888888o
 *                     88" . "88
 *                     (| ^_^ |)
 *                     O\  =  /O
 *                  ____/`---'\____
 *                .'  \\|     |//  `.
 *               /  \\|||  :  |||//  \
 *              /  _||||| -:- |||||-  \
 *              |   | \\\  -  /// |   |
 *              | \_|  ''\---/''  |   |
 *              \  .-\__  `-`  ___/-. /
 *            ___`. .'  /--.--\  `. . ___
 *          ."" '<  `.___\_<|>_/___.'  >'"".
 *        | | :  `- \`.;`\ _ /`;.`/ - ` : | |
 *        \  \ `-.   \_ __\ /__ _/   .-` /  /
 *  ========`-.____`-.___\_____/___.-`____.-'========
 *                       `=---='
 *  ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
 *         佛祖保佑       永无BUG     永不修改
 *
 */

namespace pf\cli\build;

class Base
{
    public $binds = [];
    protected static $errorMessage = '';

    public function bootstrap()
    {

        array_shift($_SERVER['argv']);
        if (count($_SERVER['argv']) == 0 || $_SERVER['argv'][0] == '-h' || $_SERVER['argv'][0] == '--help') {
            $class = 'pf\cli\\build\\help\\Command';
            $action = 'command_list';
        } else {
            $info = explode(':', array_shift($_SERVER['argv']));
            if (isset($this->binds[$info[0]])) {
                $class = $this->binds[$info[0]];
            } else {
                $class = 'pf\cli\\build\\' . strtolower($info[0]) . '\\' . ucfirst($info[0]);
            }
            $action = isset($info[1]) ? $info[1] : 'run';
        }
        //var_dump($class);exit;
        if (class_exists($class)) {
            return call_user_func_array([new $class(), $action], $_SERVER['argv']);
        } else {
            return $this->error('Command does not exist');
        }
    }

    final public function error($content)
    {
        if (php_sapi_name() == 'cli') {
            die(PHP_EOL . "\033[40m:- " . $content . "\033[0m" . PHP_EOL);
        }
        $this->setError($content);
        return false;
    }

    public function setError($content)
    {
        self::$errorMessage = $content;
    }

    final public function success($content)
    {
        if (php_sapi_name() == 'cli') {
            die(PHP_EOL . "[:- " . $content . "]" . PHP_EOL);
        }
        return true;
    }

    public function getError()
    {
        return self::$errorMessage;
    }
}