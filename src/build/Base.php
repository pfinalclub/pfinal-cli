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
    public function bootstrap()
    {

        array_shift($_SERVER['argv']);
        // 获取传递的参数
        $info = explode(':', array_shift($_SERVER['argv']));
        //var_dump($info);
        if (isset($this->binds[$info[0]])) {
            $class = $this->binds[$info[0]];
        } else {
            $class = 'pf\cli\\build\\'.strtolower($info[0]).'\\' .ucfirst($info[0]);
        }
        var_dump($class);
    }
}