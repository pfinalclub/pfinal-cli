<?php
/**
 * Created by PhpStorm.
 * User: pfinal
 * Date: 2019/1/24
 * Time: 17:25
 *
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
 *           佛祖保佑       永无BUG     永不修改
 *
 */

namespace pf\cli\build\help;

use pf\cli\build\Base;
use pf\cli\build\make\Make;

class Command extends Base
{
    public function command_list()
    {
        $command_list = $this->get_command_dir();
        $command_list_str = '\033[31mheool world \033[0m';
        //var_dump($command_list);
//        if (count($command_list) > 0) {
//            foreach ($command_list as $item) {
//                $command_list_str .= '\033[31' . $item . '\033[0m';
//                $command_self = '\pf\\cli\\build\\' . $item . '\\' . ucfirst($item);
//                $command_self_list = $command_self::$path;
//
//            }
//        }
        echo $command_list_str;
    }

    protected function get_command_dir()
    {
        $command_list = [];
        $dir = __DIR__ . '/../';
        if (!is_dir($dir)) return [];
        $dir_handle = openDir($dir);

        while (false !== $file = readDir($dir_handle)) {
            if ($file == '.' || $file == '..' || $file == 'help') continue;
            if (!is_dir($dir . $file)) continue;
            $command_list[] = $file;
        }
        return $command_list;
    }
}