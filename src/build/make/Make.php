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

    public function model($arg = [])
    {
        $dir = self::$path['model'];
        if (!(is_dir($dir) or mkdir($dir, 0755, true))) return $this->error("Directory to create failure");
        if (!$arg) {
            fwrite(STDOUT, $this->_output_for_sys("\n This method takes parameters The following parameters:\n php pf make:model  Test", "red"));
            die();
        }
        $namespace = str_replace('/', '\\', self::$path['model']);
        $info = explode('.', $arg);
        $MODEL = ucfirst($info[0]);
        $TABLE = strtolower($info[0]);
        $file = self::$path['model'] . '/' . ucfirst($MODEL) . '.php';
        if (is_file($file)) {
            return $this->error("Model file already exists");
        }
        $data = file_get_contents(__DIR__ . '/tpl/model.tpl');
        $data = str_replace(['{{NAMESPACE}}', '{{MODEL}}', '{{TABLE}}'],
            [$namespace, $MODEL, $TABLE], $data);
        if (file_put_contents($file, $data)) {
            $this->success('Command Success');
        }
    }

    public function run()
    {
        $command_list_str = $this->_output_for_sys('make',"purple");
        $command_self_list = self::$path;
        if (count($command_self_list) > 0) {
            foreach ($command_self_list as $k => $v) {
                $command_list_str .= $this->_output_for_sys('   make' . ':' . $k);
            }
        }
        fwrite(STDOUT, $command_list_str);
    }
}