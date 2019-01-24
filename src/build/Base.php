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
    protected static $sys_consone = [
        'h' => ['Command', 'help', '--help this is help'],
        'v' => ['Command', 'version', '--version  this is version'],
    ];

    public function bootstrap()
    {

        array_shift($_SERVER['argv']);
        if (count($_SERVER['argv']) == 0 || strstr($_SERVER['argv'][0], '-')) {
            if (count($this->_get_class_action($_SERVER['argv']))) {
                list($class, $action) = $this->_get_class_action($_SERVER['argv']);
            } else {
                return $this->error('Params does not exist');
            }
        } else {
            $info = explode(':', array_shift($_SERVER['argv']));
            if (isset($this->binds[$info[0]])) {
                $class = $this->binds[$info[0]];
            } else {
                $class = 'pf\cli\\build\\' . strtolower($info[0]) . '\\' . ucfirst($info[0]);
            }
            $action = isset($info[1]) ? $info[1] : 'run';
        }

        if (class_exists($class)) {
            return call_user_func_array([new $class(), $action], $_SERVER['argv']);
        } else {
            return $this->error('Command does not exist');
        }
    }

    final public function error($content)
    {
        if (php_sapi_name() == 'cli') {
            die(PHP_EOL . sprintf("\033[31m %s \033[0m \n", $content) . PHP_EOL);
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
            die(PHP_EOL . sprintf("\033[32m %s \033[0m \n",  $content ) . PHP_EOL);
        }
        return true;
    }

    public function getError()
    {
        return self::$errorMessage;
    }

    private function _get_class_action($params)
    {
        $options = [];
        if (count($params) > 0) {
            switch (trim($params[0], '-')) {
                case 'h':
                case 'help':
                    $options = ['pf\cli\\build\\help\\' . ucfirst(self::$sys_consone['h'][0]), self::$sys_consone['h'][1]];
                    break;
                case 'v':
                case 'V':
                case 'version':
                    $options = ['pf\cli\\build\\help\\' . ucfirst(self::$sys_consone['v'][0]), self::$sys_consone['v'][1]];
                    break;
                default:

                    break;
            }
        } else {
            $options = ['pf\cli\\build\\help\\' . ucfirst(self::$sys_consone['h'][0]), self::$sys_consone['h'][1]];
        }

        return $options;
    }
}