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
use pf\cli\output\Color;
use PHPUnit\Runner\Version;

class Command extends Base
{
    protected function command_list()
    {

        $command_list_str = '';
        $command_list_str .= $this->_get_params($command_list_str);
        $command_list_str .= $this->_get_command($command_list_str);
        die($command_list_str);
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

    public function help()
    {
        fwrite(STDOUT, $this->command_list());
    }

    public function version()
    {
        fwrite(STDOUT, $this->_output_for_sys("   Version 0.0.1\n   Time:2019-1-24 11:23 ToCommit \n   Author:pfianl <lampxxiezi@163.com>"));
    }

    protected function _get_command()
    {
        $command_list_str = '';
        $command_list = $this->get_command_dir();
        if (count($command_list) > 0) {
            foreach ($command_list as $item) {
                $command_list_str = $this->_output_for_sys($item);
                $command_self = '\pf\\cli\\build\\' . $item . '\\' . ucfirst($item);
                if (class_exists($command_self)) {
                    $command_self_list = $command_self::$path;
                    if (count($command_self_list) > 0) {
                        foreach ($command_self_list as $k => $v) {
                            $command_list_str .= $this->_output_for_sys('   ' . $item . ':' . $k);
                        }
                    }
                }
            }
        }
        return $command_list_str;
    }

    protected function _get_params()
    {
        $options = self::$sys_consone;
        $command_list_str = $this->_output_for_sys('Options:');
        if (count($options) > 0) {
            foreach ($options as $k => $option) {
                $command_list_str .= $this->_output_for_sys('    -' . $k . '    ' . $option[2]);
            }
        }
        return $command_list_str;
    }
}