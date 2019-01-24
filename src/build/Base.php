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

    protected static $path = [
        'controller' => 'app/Controllers',
        'model' => 'app/model',
    ];

    public function bootstrap()
    {
        array_shift($_SERVER['argv']);
        // 获取传递的参数
        $info = explode(':', array_shift($_SERVER['argv']));
        //var_dump($info);
        if (isset($this->binds[$info[0]])) {
            $class = $this->binds[$info[0]];
        } else {
            $class = 'pf\cli\\build\\' . strtolower($info[0]) . '\\' . ucfirst($info[0]);
        }
        $action = isset($info[1]) ? $info[1] : 'run';
        if (class_exists($class)) {
            return call_user_func_array([new $class(), $action], $_SERVER['argv']);
        } else {
            return $this->error('Command does not exist');
        }
    }

    final public function error($content)
    {
        if (php_sapi_name() == 'cli') {
            die(PHP_EOL . "[:- " . $content . "]" . PHP_EOL);
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