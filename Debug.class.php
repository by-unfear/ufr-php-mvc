<?php
class Debug {

    private static $debug = [];

    public static function get($msg) {
        self::$debug[] = $msg;
    }
    public static function display() {
        foreach (self::$debug as $v) {
            echo "<p style='padding:6px 12px; margin:0px 0px 4px; background:#b00; color:#fff;'>{$v}</p>";
        }
    }

}
