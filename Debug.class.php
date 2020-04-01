<?php
class Debug {

    private static $debug = [];
    private static $display = true;
    private static $logfile = true;
    private static $console = false;
    private static $email = false;
    private static $clear = false;
    private static $errorfile = 'erro.log';

    public static function set($msg) {
        self::$debug[] = addslashes(str_replace('\\', '/', $msg));
    }
    public static function assert($condition, $msg) {
        if (!$condition) {
            throw new Exception($msg);
        }
    }
    public static function display() {
        foreach (self::$debug as $v) {
            echo $v;
        }
    }

    public static function develop() {
        self::$display = true;
        self::$logfile = true;
    }

    public static function watchmen() {
        self::$logfile = true;
        self::$email = true;
    }

    public static function deploy() {
        self::$logfile = true;
    }

    public static function clear() {
        self::$clear = true;
    }

    public static function Exception($e) {
        $code = $e->getCode();
        $msg = $e->getMessage();
        $array = $e->getTrace();

        var_export($array, true);
        if (is_array($array)) {
            if (count($array)>0){
                $file = $array[0]['file'];
                $line = $array[0]['line'];
            }else{
                $file = 'unknow';
                $line = 'unknow';
            }
        } else {
            $file = $e->getFile();
            $line = $e->getLine();
        }

        $trace = $e->getTraceAsString();
        //$trace = str_replace(DB_PASS, '********', $trace);

        self::error($code, $msg, $file, $line, $trace);
    }

    public static function error($code, $msg, $file, $line, $trace) {

        $exit = false;
        $date = date('d-m-Y H:i:s');
        switch ($code) {
            case E_NOTICE:
            case E_USER_NOTICE:
                $type = 'Aviso';
                break;
            case E_WARNING:
            case E_USER_WARNING:
                $type = 'Alerta';
                break;
            case E_ERROR:
            case E_USER_ERROR:
                $type = 'Erro Fatal';
                $exit = true;
                break;
            default:
                $type = 'Desconhecido';
                $exit = true;
                break;
        }
        if (self::$display === true) {
            $log = "<div style='background:#f44; padding:2px 5px; width:100%; position:relative; z-index:9999;'>";
            $log .= "<div style='font-family:monospace; letter-spacing:-0.2; background:#444; padding:4px 8px; color:#bbb; border:#777 solid 1px;'>";
            $log .= "[{$date}] - ";
            $log .= "{$type}<br/>";
            $log .= "Msg:&nbsp; {$msg}<br/>";
            $log .= "File: {$file} - ";
            $log .= "Line: {$line}<br/>";
            // $log .= "Stack trace:\n";
            // $log .= var_export($trace, true)."\n";
            $log .= "</div>";
            $log .= "</div>";
            echo $log;
            //echo '<br/>'.nl2br($trace);
        }
        if (self::$logfile === true) {

            $log = "[{$date}] - ";
            $log .= "{$type} \n";
            $log .= "Msg:  {$msg}\n";
            $log .= "File: {$file}";
            $log .= "Line: {$line}\n";
            // $log .= "Stack trace:\n";
            // $log .= var_export($trace, true)."\n";
            $log .= "\n\n";

            if (is_file(APPDIR . DS . self::$errorfile) === false) {
                file_put_contents(APPDIR . DS . self::$errorfile, '');
            }

            if (self::$clear) {
                $f = fopen(APPDIR . DS . self::$errorfile, "r+");
                if ($f !== false) {
                    ftruncate($f, 0);
                    fclose($f);
                }
            }

            file_put_contents(APPDIR . DS . self::$errorfile, $log, FILE_APPEND);

        }
        if (true == $exit) {
            exit();
        }
    }

}
