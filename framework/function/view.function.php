<?php
	if (!function_exists('view')) {
		function view($path = null, $args = []) {
			if ($path !== null) {
				if (is_array($args) && count($args) > 0) {
					foreach ($args as $c => $v) {
						${$c} = $v;
					}
				}
				$file = str_replace('/', DS, ltrim(Config::get('view'), '/') . DS . $path . '.view.php');
				if (file_exists($file)) {
					unset($path);
					unset($args);
					unset($c);
					unset($v);
					require $file;
				} else {
					throw new Exception("[view] {$file} não encontrada");
				}
			}
		}
	}