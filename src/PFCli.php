<?php
/**
 * Created by PhpStorm.
 * User: nancheng
 * Date: 2019/1/23
 * Time: 10:29 PM
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

namespace pf\cli;

use pf\cli\build\Base;

class PFCli
{
    protected static $link;

    public function __call($method, $params)
    {
        return call_user_func_array([static::single(), $method], $params);
    }

    public static function single()
    {
        if ( ! self::$link) {
            self::$link = new Base();
        }
        return self::$link;
    }
    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([static::single(), $name], $arguments);
    }
}