<?php

namespace Astronphp\Debugbar;

class WriteLogs{

	public static function AccessTimersLog($executationTime){
        if(!file_exists(PATH_ROOT.'storage/log/access/')){
			mkdir(PATH_ROOT.'storage/log/access/', 0777, true);
			$fh = fopen(PATH_ROOT.'storage/log/access/timers.log', 'w+');
			fclose($fh);
		}

        if($fh = fopen(PATH_ROOT.'storage/log/access/timers.log', 'r')) {
			while (!feof($fh)) {
				$line = fgets($fh);
				if(strlen($line)>10){
					$objectTimer[] = unserialize($line);
				}
			}
			fclose($fh);
		}
		$objectTimer[] = $executationTime;

		$objectTimer	= array_slice($objectTimer, -20, 20);

		if($fh = fopen(PATH_ROOT.'storage/log/access/timers.log', 'w+')) {
			$text='';
			foreach ($objectTimer as $key => $value) {
				$text.=serialize($value)."\r\n";
			}
			fwrite($fh, $text);
			fclose($fh);
        }
        return $objectTimer;
    }
}