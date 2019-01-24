<?php
/**
 * Created by PhpStorm.
 * User: nancheng
 * Date: 2019/1/23
 * Time: 11:10 PM
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

namespace pf\cli\build\make;

use pf\cli\build\Base;

class Make extends Base
{
    public static $path = [
        'controller' => 'app/Controllers',
        'middleware' => 'app/middleware',
        'migration' => 'app/migration',
        'model' => 'app/model',
        'request' => 'app/request',
        'seed' => 'app/seed',
        'service' => 'app/service',
        'tag' => 'app/tag',
        'test' => 'tests',
    ];

    public function controller($arg, $type = 'controller')
    {
        $info = @explode('/', $arg);
        $MODULE = $info[0];
        $file = self::$path['controller'];
        if (isset($info[1])) {
            $CONTROLLER = ucfirst($info[1]);
            $file .= '/' . $MODULE . '/' . $CONTROLLER . '.php';
        } else {
            $file .= '/' . ucfirst($MODULE) . '.php';
        }
        $dir = dirname($file);
        if (!empty($dir)) {
            if (!(is_dir(dirname($file)) or mkdir(dirname($file), 0755, true))) return $this->error("Directory to create failure");
        }
        //var_dump($file);
        if (is_file($file)) return $this->error('Controller file already exists');
        $data = file_get_contents(__DIR__ . '/tpl/' . strtolower($type) . '.tpl');
        if (isset($info[1])) {
            $data = str_replace(['{{APP}}', '{{MODULE}}', '{{CONTROLLER}}'], ['App', ucfirst($MODULE), ucfirst($CONTROLLER)], $data);
        } else {
            $data = str_replace(['{{APP}}', '{{MODULE}}', '{{CONTROLLER}}'], ['App', '', ucfirst($MODULE)], $data);
        }
        if (file_put_contents($file, $data)) {
            $this->success('Command Success');
        }
    }

    public function run()
    {
        $command_list_str = sprintf("\033[35m %s \033[0m \n", 'make');
        $command_self_list = self::$path;
        if (count($command_self_list) > 0) {
            foreach ($command_self_list as $k => $v) {
                $command_list_str .= sprintf("\033[32m   %s \033[0m \n", 'make' . ':' . $k);
            }
        }
        die($command_list_str);
    }
}