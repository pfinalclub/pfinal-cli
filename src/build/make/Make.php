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
        if (!empty(dirname($file))) {
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
        return file_put_contents($file, $data);
    }
}