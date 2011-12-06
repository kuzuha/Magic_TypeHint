<?php
namespace Magic;

/**
 * Created by JetBrains PhpStorm.
 * User: Kuzuha SHINODA
 * Date: 11/12/06
 * Time: 13:18
 * To change this template use File | Settings | File Templates.
 */
class TypeHint
{
    static function register()
    {
        set_error_handler(function($err_no, $err_str, $err_file, $err_line)
        {
            $pattern = '/Argument (\d+) passed to [^ ]+ must be an instance of [^,]*?\\\\?([^\\\\,]+),/';
            if (preg_match($pattern, $err_str, $matches)) {
                switch ($matches[2]) {
                    case 'int':
                    case 'string':
                    case 'callable':
                    case 'bool':
                    case 'float':
                    case 'numeric':
                    case 'object':
                    case 'resource':
                    case 'scalar':
                        $validate_func = 'is_' . $matches[2];
                        break;
                    default:
                        return false;
                }
                $trace = debug_backtrace();
                if (!$validate_func($trace[1]['args'][$matches[1] - 1])) {
                    throw new \InvalidArgumentException(preg_replace('/an instance of [^,]*?\\\\?([^\\\\,]+),/', "$matches[2],", $err_str));
                }
                return true;
            }
            return false;
        }, E_RECOVERABLE_ERROR);
    }

    static function unregister()
    {
        set_error_handler(function($err_no, $err_str, $err_file, $err_line)
        {
            return false;
        }, E_RECOVERABLE_ERROR);
    }
}
