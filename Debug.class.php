<?php
class Debug {

    private static $debug = [];

    public static function get($msg) {
        self::$debug[] = addslashes(str_replace('\\', '/', $msg));
    }
    public static function display() {
        foreach (self::$debug as $v) {
			echo $v;
            // echo "<p style='padding:6px 12px; margin:0px 0px 4px; background:#b00; color:#fff;'>{$v}</p>";
        }
    }

    private static $display = true;
	private static $logfile = true;
	private static $console = false;
	private static $email = false;
	private static $clear = false;
	private static $errorfile = 'erro.log';

	function __construct(){
	}

	public static function develop(){
		self::$display = true;
		self::$logfile = true;
	}

	public static function watchmen(){
		self::$logfile = true;
		self::$email = true;
	}

	public static function deploy(){
		self::$logfile = true;
	}

	public static function clear(){
		self::$clear = true;
	}

	public static function Exception($e){

		$code= $e->getCode();
		$msg= $e->getMessage();
		$array= $e->getTrace();

		// $file= $e->getFile();
		// $line= $e->getLine();
		$file= $array[0]['file'];
		$line= $array[0]['line'];

		$trace = $e->getTraceAsString();
		//$trace = str_replace(DB_PASS, '********', $trace);

		self::log($code, $msg, $file, $line, $trace);
	}

	public static function log($code, $msg, $file, $line, $trace){

		$exit = false;
		$type= 'Desconhecido';
		// switch($level){
		// 	case E_NOTICE:
		// 	case E_USER_NOTICE:
		// 		$type= 'Aviso';
		// 		break;
		// 	case E_WARNING:
		// 	case E_USER_WARNING:
		// 		$type= 'Alerta';
		// 		break;
		// 	case E_ERROR:
		// 	case E_USER_ERROR:
		// 		$type= 'Erro Fatal';
		// 		$exit  = true;
		// 		break;
		// 	default:
		// 		$type= 'Desconhecido';
		// 		$exit = true;
		// 		break;
		// }
		if(self::$display === true){
			self::$debug[] = '
				<div style=\'background:#eee; margin:2px 1%; padding:4px 8px; color:#999; position:relative; z-index:9999;\'>
					['.date('d-m-Y H:i:s').'] 
					<b style=\'color:#d00;\'>'.$type.' #'.$code.'</b>: 
					<b style=\'color:#000;\'>'.$msg.'</b> em 
					<span style=\'color:#000;\'>'.$file.'</span> na linha 
					<span style=\'color:#000;\'>'.$line.'</span> 
					de ['.$_SERVER['REQUEST_URI'].'] 
				</div>
			';
			//echo '<br/>'.nl2br($trace);
		}
		if(self::$logfile === true){

			$date = date('d-m-Y H:i:s');
			$log = "Exception information:\n";
			$log .= "Date: {$date}\n";
			$log .= "Message: {$msg}\n";
			$log .= "Code: {$code}\n";
			$log .= "File: {$file}\n";
			$log .= "Line: {$line}\n";
			$log .= "Stack trace:\n";
			// $log .= "{$trace}\n\n\n";

			if (is_file(APPDIR.self::$errorfile) === false) {
				file_put_contents(APPDIR.self::$errorfile, '');
			}

			if (self::$clear) {
				$f = fopen(APPDIR.self::$errorfile, "r+");
				if ($f !== false) {
					ftruncate($f, 0);
					fclose($f);
				}
			}

			file_put_contents(APPDIR.self::$errorfile, $log, FILE_APPEND);

		}
		if(self::$console === true){
            $date = date('d-m-Y H:i:s');
			$log = "{$msg} ";
			$log .= "[{$code}]";
			$log .= "{$file}";
			$log .= "({$line})";
			$log = addslashes($log);
            echo "<script>console.log('{$log}');</script>";
        }
		if(true==$exit){
			exit();
		}
	}

}
