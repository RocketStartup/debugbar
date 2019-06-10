<?php

namespace Astronphp\Debugbar;

class View{
	
	public $executationTime = null;
	public $ramMemory		= 0;
	public $errorsRecords 	= 0;
	public $sqlRecords 		= 0;
	public $objectTimer		= null;
	public $suffixes   		= array('b', 'K', 'M', 'G');

	public function __construct(){

	}

	public function closeVars(){
		$microtime 	= microtime(true);
		$timer=\Performace::getInstance('Timer');

		$this->response 			= http_response_code();

		$this->executationTime		=	new \Astronphp\Debugbar\ExecutationTime();
		$this->objectTimer			=	\Astronphp\Debugbar\WriteLogs::AccessTimersLog($this->executationTime);
		$this->executationTime		=	$this->executationTime->instance();

		$this->ramMemory			=	new \Astronphp\Debugbar\RamMemory();
		$this->ramMemory			=	$this->ramMemory->instance();
		$this->sqlRecords 			= 0;
		$this->errorsRecords 		= 0;
		   
		return $this;
	}

	public function getExecutationTime(){
		$r='<table class="mntbopen" id="speedID" cellpadding="10">';
		$r.='	<tbody>';
		$r.='			<tr valign="top">';
		$r.='				<td width="2%"></td>';
		$r.='				<td width="30%">';
		$r.='					<p class="titlebar">';
		$r.='						<img width="18px" src="data:image/png;base64,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">';
		$r.='						Execution Time ('.$this->executationTime['systemload']['time'].' ms)';
		$r.='					</p>';
		$r.='					<table class="details" width="100%">';
		foreach ($this->executationTime as $key => $value) {
			if($key=='systemload'){ continue; }
			$r.='						<tr>';
			$r.='							<td><i class="clbr" style="background:'.$value['color'].';"></i> '.$value['name'].'</td><td>'.$value['time'].'ms</td><td>'.$value['percent'].'%</td>';
			$r.='						</tr>';
		}
		$r.='					</table>';
		$r.='				</td>';
		$r.='				<td>';
		$r.='					<p class="titlebar">';
		$r.='						<span class="headerbarcomands">';
		$r.='							<a href="#" onclick="openbar(\'\'); return false;"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACYAAAAnCAYAAABjYToLAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABx0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzIENTNui8sowAAAE0SURBVFiF3dhLjsIwDIBhM5o9B+Bso0gVr7PBisOxQ/pZEEOmYpLGTYo1lrygau2vJGrTrADxGF+j32sRGT7gGGLvVwCa38AJuAIhOd47Q+x5igYBJEVd+B3bBVDbUc+L4gTYAGfeR0/cGKVxBjb6V+aiB+4vlEZIxzkXu4aoXQlFMscE2C+AK6H2eq75QkNW3bilgAVXXbNZoZaoHKwVzlyjVPgwA1dCHXK9pwxFCfeugeWaalhto9moGtiUhj8xZ6NqYVNwTVAWmBVXhbLCBDhWoI6WHlaY8JhPtwzoFs8x1R8vrf3EfxpKl5Pf5ePC5QPW5SvJ5Uvc5bLH5ULR5dLa5ceIy8+3nqipPZ44vSDU3E1nXFBYCfWxTRW321CC0427FOduq1NzDQwLojSH2Pt57A6HxtlxOOnGGAAAAABJRU5ErkJggg=="/></a>';
		$r.='						</span><br/>';
		$r.='					</p>';
		$r.='					<table class="details" width="100%">';
		foreach ($this->executationTime as $key => $value) {
			if($key=='systemload'){ continue; }
			$r.='						<tr><td bgcolor="#555"><i class="clbr" style="background:'.$value['color'].'; width: '.$value['percent'].'%;"></i></td></tr>';
		}
		$r.='					</table>';
		$r.='				</td>';
		$r.='				<td width="2%"></td>';
		$r.='			</tr>';
		$r.='	</tbody>';
		$r.='</table>';
		return $r;
	}
	
	public function getRamMemory(){
			$r='<table class="mntbopen"  id="ramID" cellpadding="10">';
			$r.='		<tbody>';
			$r.='			<tr valign="top">';
			$r.='				<td width="2%"></td>';
			$r.='				<td width="30%">';
			$r.='						<p class="titlebar">';
			$r.='							<img width="18px" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACYAAAAnCAYAAABjYToLAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABx0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzIENTNui8sowAAAUdSURBVFiF1ZhLbBVlFMd/99LSllJaqIBCS31AQGwl1pUxqSTGFwKJGhay0IUmPpbudKEujBoXmpi4MQGNLowSExLfkvgILDDGFAVBg6BoSQsIYi3cPu/fxTkf83XunXtriq2eZDJz/3PmzP87c17fRRJljmskfSRpj6SbHLtB0peSdkla59jtkr6StFPSlY7dK6lX0puSFjv2qKQDkl6RNM+xJyQdlPSspNo0hxrKSx3QDiwAGhxrAFYAI0C9Y/OBDmAOUOvYAtc7AxfstwBtwFIg71irY5cAuTSBLGKBRJO/KCYxAsxzrDl6WSC7yI+2iOxi123zRQBc6vaXRWQvSAkQiTKwLHwqMuVns4jFBJTCKt2bLlaVWC66l09heZKYiHUuBlaV2BySmAkxUeMG6kliM5zrI1sBq4teWFsFK5Gs4P8FeM5f+K1jB4HngXHgJ8e+Bl7EMrDfsS+Al4FjwFnHPgCKwPdAwbF3gJPAXrc5SXLSVON2ZiXtsQVYajdEWI7E/UU/h88WAjfW+acYwATwF+bB0TSxDuAuYDNwBTB36uublhSdVC/wFvA5cC60gHZJr0oakDSh2ZGCrEXdJ6m5Bqvcm4FNfj1bUg9cDWwBWmuA5cCtwJJZJBXL9UBHDdYD27CAPgL8AAwxOUgbgJXYigQcAI5ifTMujk3AWixeC1ipOY6VgxxlCikWY3nMMeuwr9aKpPWS9vt3fkHSIkk5JSNITlKTpMdk8VeQ9JCkRk0eVfKSlshGG0k6Juk2SXUpvTmSalJYraRu2QglSUqXi1+xYgmw0Ff4J5Y1R9xbReAwcA7L6mYs3c9i6d7nzxeAH0nGpCZg2G2BTSjz3c454BBJQS5pSaFOXQu8B3wGrHdsLNKb8PNGrNK/C6xK2Yj1HgF2Yx2h0bHHgT3AM+6ACaJmnvZYILoIuNGvQ1KEthHHSjvQ6UabUzbieFoFrMY8FnrkWse7/BnFz2T1ysO+okZs+nwQuNkNTEQGdmM99Q+sN6Yl6A37+TyJRwsRNolUJWLHsYYN8DTwVHQvJrbPj2qSi865DGxS004TC6tpwNw8FysdH2Kf4io3EvQWut4wVmZGo3uKrsthSmH5CCsJ/vC7E9gJfIxl2Z2Y14okcxnABuAT4G2szqVtpofCXJl75bASj7UBlzmxsJlox5KhyVeUdxKHsABucb0urLQsc1uhxYTiCRazncBpzNtgSdPpXMLGh5ykHuAloBsbAI9io0+XKx/EvLbciYSBbwCr8KuxWnUAq4ErsenkPPAdFgprfKGDjo25raVOcr8voMuJjuckdWOfaSOVd00zJf3A73ksAz/FqvZ/Qb4BXs8DJ7Aq/75fFys99S/KMBa3O4Dt8cx/OTbBbmJmJ1hROsEOpTcjszHzhz45SDTz/292SUFWAA9gtegNrDysAe7Hmvl24Gds2tyKlYltWAnpAe7Beuc2rLZtAO5wO69h5WULNrnsxT7h5L2lyv8/1iNp1Ge2rY7dHW0cbnHsYf89KOk6x56MBsUOx8Lw2CupxbEdju2SVJ/mkFW3JkgmgjBTjWMxMRytLpyHSeIvYCMkvW+sClYilf7tyWrAxch4rHMxsKrEKo0nle5NF6tKLH4wi3A13Sybae+UfTYrKwtYVrWQbB6GHBvBGjRYxp3AmnyIyTN+9JHE0SnX7SP5hANuu58y3SaL2IgbGYxIFLBd1BhJwA451h+RGAR+cywkwlm3dzIicRrr06coE2N/A8gmY9HisEffAAAAAElFTkSuQmCC">';
			$r.='							RAM Memory (2.19 MB)';
			$r.='						</p>';
			$r.='						<table class="details" width="100%">';
			foreach ($this->ramMemory as $key => $value) {
				$r.='						<tr>';
				$r.='							<td><i class="clbr" style="background:'.$value['color'].';"></i> '.$value['name'].'</td><td>'.$value['time'].' mb</td><td>'.$value['percent'].'</td>';
				$r.='						</tr>';
			}
			$r.='						</table>';
			$r.='					</td>';
			$r.='					<td>';
			$r.='						<p class="titlebar">';
			$r.='							<span class="headerbarcomands">';
			$r.='								<a href="#" onclick="openbar(\'\'); return false;"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACYAAAAnCAYAAABjYToLAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABx0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzIENTNui8sowAAAE0SURBVFiF3dhLjsIwDIBhM5o9B+Bso0gVr7PBisOxQ/pZEEOmYpLGTYo1lrygau2vJGrTrADxGF+j32sRGT7gGGLvVwCa38AJuAIhOd47Q+x5igYBJEVd+B3bBVDbUc+L4gTYAGfeR0/cGKVxBjb6V+aiB+4vlEZIxzkXu4aoXQlFMscE2C+AK6H2eq75QkNW3bilgAVXXbNZoZaoHKwVzlyjVPgwA1dCHXK9pwxFCfeugeWaalhto9moGtiUhj8xZ6NqYVNwTVAWmBVXhbLCBDhWoI6WHlaY8JhPtwzoFs8x1R8vrf3EfxpKl5Pf5ePC5QPW5SvJ5Uvc5bLH5ULR5dLa5ceIy8+3nqipPZ44vSDU3E1nXFBYCfWxTRW321CC0427FOduq1NzDQwLojSH2Pt57A6HxtlxOOnGGAAAAABJRU5ErkJggg=="/></a>';
			$r.='							</span>';
			$r.='							<br/>';
			$r.='						</p>';
			$r.='						<table class="details" width="100%">';
			foreach ($this->ramMemory as $key => $value) {
				if($key=='memorypeak' || $key=='memorylimit'){ continue; }
				$r.='						<tr><td bgcolor="#555"><i class="clbr" style="background:'.$value['color'].'; width: '.$value['percent'].'"></i></td></tr>';
			}
			$r.='						</table>';
			$r.='					</td>';
			$r.='					<td width="2%"></td>';
			$r.='				</tr>';
			$r.='		</tbody>';
			$r.='</table>';
		return $r;
	}
	
	
	public function getErrorsLog(){
			$l='';
			if($fh = fopen(PATH_ROOT.'storage/log/Error/php.log', 'r')) {
				while (!feof($fh)) {
					$line = fgets($fh);
					$l.="<br>".$line;
					if(substr($line,1,10)=='----------'){
						$this->errorsRecords++;
					}
				}
				fclose($fh);
			}	
			$r='	<table class="mntbopen" id="errorsID" cellpadding="10">';
			$r.='		<tbody>';
			$r.='				<tr valign="top">';
			$r.='					<td width="2%"></td>';
			$r.='					<td>';
			$r.='						<p class="titlebar">';
			$r.='							<img width="18px" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACYAAAAnCAYAAABjYToLAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABx0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzIENTNui8sowAAAUUSURBVFiFzdhryJ51HQfwz/089+5tbmOewOEhy/BEZqVzZlpBRRpYIKTiAbLeDMTyTQS9CAbZi1DCyhfSigKVbBZEMKesZCmTpCnzME8DN6U5sWk7uM0987l/vfj9r+6r2/u6D88D4hcu7v91/Q/39/r9f4fv/2pFhA8jpvAp3IZ3EBNcB/ELfKSs1cKleATdMea/h7uxtInY1ViJzoQv1cFFWFXul+LL+NgYc/fiz9iAIwNHRMQ7EXEk5o61ESEiTouIbSPGvhcRWyNiTUScW+YNvNpYMqGl+rGw/E5h0ZBxb+Ex/Aob5VY2oj1PUv1oiqRXcW8h9RoWYDEOf1DE+tHFU/gZHsQ+rMBlpb3xgyLWqrVn8RBul1vYxdewGu/KiGxEG4dkhM2V5Ez57dbaB/FH3ImtOAnfwTdxgdzWbaOI/Vami4vnQOpFPFraB+R2zWIT7sBOfBbfLqSOL2O349+jiN1eSF0uo6pKgK0B4+vPj+DvWF/u90vn/gc243V8HTeXtevz3h7+vjTmkXleiyLixojYMiCX7Y2I1aPWaJc3WYrlMhfV0ZXRc6D2rCW3ZEkZ35LlbE+x6CLchFtxzgBbLDZGlWnjEllKrtVLlhVm5FatlX4xLUP9FlljO9JX7sVdheS38L0GUsqcZaOIiYi/RcQrQ8rI2xHxw2LiEyPigYg4Wuu/PyLOjIgFEXFdRDw9ZK0KP4+IJcO2UkR0yzUM90SvHm6vPV8XEWeXvksj4vExSEVErI+Ii4YRq3xkUATW0ar9Vu0n8Gu8JBXFLVJtjIML8LlhA/qdfRxMyVz1e6m9jsE3cKXxk/QKfFFPy82b2JRe/dssFcIq3GhylXIxrtegSCYlNi0jdQOeL4teJremyR1mZCo52vf8ZJkJPj9o7ly2ci/+KWvsSnxpxDqv4B6Ds/0n8QNcOF9i70pL7S73dWk9CIeltFknE3U/pvEF/Aif6Cd2yPvN3I+6anhCqtFjcZ7hvvUc7pPicH/DmA6ukEn5f+eFKfwGW4Ys/qJUCxWxjXhDZv6PD5lHBsee8vsvzXK6g2vKtZwM7zvkdnxVlqRKHrekEnhUOjtp2Z2lfY7mcJ+V1vqLtPYMXpY197iGOcfiBqnfHp6PgvhJRBxuyOzPR8RVtbGdiLg2InaMURVui4gVlbpYVhgPCoYq27el8+8qFjne4BzULZbaVHs2I/PeS/hog8UqXIjr2/L0XKmLSijWUd13sEMmxV0NpEKqkE34T1/fbvyhEDt7CLGzsLCNH8toOH3Em5BWW1zagxx5Bn+VKaUfs/gTTsB3NfvnSVjeljVrVBGv/3Glpd6SwbCg1n9UppNdDfP343fl/1YbHNUL0a7Uxbjo4LQyZ6deoq3QlVp/dsgae+QBaH1D/wHsnjTzL8K50mrb9FLHpNgjy9qgDyqvYfOkxI7BZ2QEb5WOXkdL+tA42Gdw/Xwa901KbCHOx4nS5M/KklZhGmdI4qPQ9f5S+KYMng1zURen6oX743oHXnrfzE4dY52O//9od1AeejYwN9mzGF+R+WiLVA5vlr4qyleOsc5xepbdJ09Za6X/zfnD3euRB1oRcUJE3BoRz9X6H46IVdFczpZHxE/L2B0R8f2IOLk+ZnrNmjVLZHScLn1kHCyTKuBVvCB9bbtMFYekOq36B32juEQq12fwS9yvLxCm8ACe1NNc42KVjFCFzIPy09JGWY7Ox6cb5p4iI3idrAYH+wf8F67WLV9d5iCyAAAAAElFTkSuQmCC">';
			$r.='							Erros ('.$this->errorsRecords.')';
			$r.='							<span class="headerbarcomands">';
			//$r.='								<a href="#" onclick="openbar(\'\'); return false;"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACYAAAAnCAYAAABjYToLAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABx0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzIENTNui8sowAAAE0SURBVFiF3dhLjsIwDIBhM5o9B+Bso0gVr7PBisOxQ/pZEEOmYpLGTYo1lrygau2vJGrTrADxGF+j32sRGT7gGGLvVwCa38AJuAIhOd47Q+x5igYBJEVd+B3bBVDbUc+L4gTYAGfeR0/cGKVxBjb6V+aiB+4vlEZIxzkXu4aoXQlFMscE2C+AK6H2eq75QkNW3bilgAVXXbNZoZaoHKwVzlyjVPgwA1dCHXK9pwxFCfeugeWaalhto9moGtiUhj8xZ6NqYVNwTVAWmBVXhbLCBDhWoI6WHlaY8JhPtwzoFs8x1R8vrf3EfxpKl5Pf5ePC5QPW5SvJ5Uvc5bLH5ULR5dLa5ceIy8+3nqipPZ44vSDU3E1nXFBYCfWxTRW321CC0427FOduq1NzDQwLojSH2Pt57A6HxtlxOOnGGAAAAABJRU5ErkJggg=="/></a>';
			$r.='								<a href="#" style="float:right"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACYAAAAnCAYAAABjYToLAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABx0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzIENTNui8sowAAAJoSURBVFiF7dhLaxRBFAXgb2aiQRcRfIEhLsQH4gNBFEFUdCtIduJPcCXoQsR/kp3u3LlQyEIERQRBEBFRgoaoK41EwTxNdMpF9TA97fQ4PZlJXORAM31PVc89VXW7760qhRD8j+hbxrP7MIwBVDNtJSzhEZ509O8hhE6usyGE8RDCYsjHUgjhSwjhcic+Sh0u5XMcq40Nc8ks1ex1WJ/Y8xjCtyIOyh2IKmNrcv8Sh7A7ufYkv3txJ+mzATuKOukkxqpi/MAo3uT0u4VLyf1sUSfNlvIoroijbLbOJZzCRnxIhFUyfaoYxJHEfopp9eVO/9c0buNeQ0sm6E6GECZbBHQvcTOtJRtj17CtxQz3EufTRlbY5hUUksVc2sgKW800UM418HgFhWTxq8HKBH9/CGFkFQL/YQhhf2jjy38QW/ydA7uNMmbwItvQaUrqOfK+/AO4gX69fSHKGMFYtiFvxnbiUw8FpXEB97NkXhKvys9vUxhvwn/FRBN+UkxdeVhqRhatLhZwDgfwKsXP4nTCv03xP3BCfJneF3FUVNhM4mAR71L898Re0Dg7U4k9h4+9FFZSLwD72uRrdrYC6bqwUuq+U77rwlYMa8KKYk1YUawJK4o1YUVRVFhQr8+qOXxoo3/XhdVK4eyzFTGB05h6KuqbjEK5stXZRbPctkmsbMfEMqeG7bguVhLHU/wgruKzePTQrp/cCrZfLG+G8nV3DYfxOkvmLeVPPOupnIhxTep9Wu+SdonnXwM9EkU8rxht1tAq+CdwBg/EgP/dpWteHPBwnija31deFE8Ol7uVq4gDvusfR59/AHKiK3TgQUCZAAAAAElFTkSuQmCC"/></a>';
			$r.='							</span>';
			$r.='						</p>';
			$r.='						<div class="scllcd">';
			$r.='							<code>'.$l."</code>";
			$r.='						</div>		';
			$r.='					</td>';
			$r.='					<td width="2%"></td>';
			$r.='				</tr>';
			$r.='		</tbody>';
			$r.='	</table>';
			
		return $r;
	}

	public function getHistoryTime(){
		$r='		<table class="mntbopen" id="historyID"  cellpadding="10">';
		$r.='		<tbody>';
		$r.='				<tr valign="top">';
		$r.='					<td width="2%"></td>';
		$r.='					<td>';
		$r.='						<p class="titlebar">';
		$r.='							<img width="18px" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACYAAAAnCAYAAABjYToLAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABx0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzIENTNui8sowAAAUUSURBVFiFzdhryJ51HQfwz/089+5tbmOewOEhy/BEZqVzZlpBRRpYIKTiAbLeDMTyTQS9CAbZi1DCyhfSigKVbBZEMKesZCmTpCnzME8DN6U5sWk7uM0987l/vfj9r+6r2/u6D88D4hcu7v91/Q/39/r9f4fv/2pFhA8jpvAp3IZ3EBNcB/ELfKSs1cKleATdMea/h7uxtInY1ViJzoQv1cFFWFXul+LL+NgYc/fiz9iAIwNHRMQ7EXEk5o61ESEiTouIbSPGvhcRWyNiTUScW+YNvNpYMqGl+rGw/E5h0ZBxb+Ex/Aob5VY2oj1PUv1oiqRXcW8h9RoWYDEOf1DE+tHFU/gZHsQ+rMBlpb3xgyLWqrVn8RBul1vYxdewGu/KiGxEG4dkhM2V5Ez57dbaB/FH3ImtOAnfwTdxgdzWbaOI/Vami4vnQOpFPFraB+R2zWIT7sBOfBbfLqSOL2O349+jiN1eSF0uo6pKgK0B4+vPj+DvWF/u90vn/gc243V8HTeXtevz3h7+vjTmkXleiyLixojYMiCX7Y2I1aPWaJc3WYrlMhfV0ZXRc6D2rCW3ZEkZ35LlbE+x6CLchFtxzgBbLDZGlWnjEllKrtVLlhVm5FatlX4xLUP9FlljO9JX7sVdheS38L0GUsqcZaOIiYi/RcQrQ8rI2xHxw2LiEyPigYg4Wuu/PyLOjIgFEXFdRDw9ZK0KP4+IJcO2UkR0yzUM90SvHm6vPV8XEWeXvksj4vExSEVErI+Ii4YRq3xkUATW0ar9Vu0n8Gu8JBXFLVJtjIML8LlhA/qdfRxMyVz1e6m9jsE3cKXxk/QKfFFPy82b2JRe/dssFcIq3GhylXIxrtegSCYlNi0jdQOeL4teJremyR1mZCo52vf8ZJkJPj9o7ly2ci/+KWvsSnxpxDqv4B6Ds/0n8QNcOF9i70pL7S73dWk9CIeltFknE3U/pvEF/Aif6Cd2yPvN3I+6anhCqtFjcZ7hvvUc7pPicH/DmA6ukEn5f+eFKfwGW4Ys/qJUCxWxjXhDZv6PD5lHBsee8vsvzXK6g2vKtZwM7zvkdnxVlqRKHrekEnhUOjtp2Z2lfY7mcJ+V1vqLtPYMXpY197iGOcfiBqnfHp6PgvhJRBxuyOzPR8RVtbGdiLg2InaMURVui4gVlbpYVhgPCoYq27el8+8qFjne4BzULZbaVHs2I/PeS/hog8UqXIjr2/L0XKmLSijWUd13sEMmxV0NpEKqkE34T1/fbvyhEDt7CLGzsLCNH8toOH3Em5BWW1zagxx5Bn+VKaUfs/gTTsB3NfvnSVjeljVrVBGv/3Glpd6SwbCg1n9UppNdDfP343fl/1YbHNUL0a7Uxbjo4LQyZ6deoq3QlVp/dsgae+QBaH1D/wHsnjTzL8K50mrb9FLHpNgjy9qgDyqvYfOkxI7BZ2QEb5WOXkdL+tA42Gdw/Xwa901KbCHOx4nS5M/KklZhGmdI4qPQ9f5S+KYMng1zURen6oX743oHXnrfzE4dY52O//9od1AeejYwN9mzGF+R+WiLVA5vlr4qyleOsc5xepbdJ09Za6X/zfnD3euRB1oRcUJE3BoRz9X6H46IVdFczpZHxE/L2B0R8f2IOLk+ZnrNmjVLZHScLn1kHCyTKuBVvCB9bbtMFYekOq36B32juEQq12fwS9yvLxCm8ACe1NNc42KVjFCFzIPy09JGWY7Ox6cb5p4iI3idrAYH+wf8F67WLV9d5iCyAAAAAElFTkSuQmCC">';
		$r.='							History';
		$r.='							<span class="headerbarcomands">';
		
		$r.='								<select style="width:50px" onchange="historylog(this.value);">';
		$r.='									<option>All</option>';
		$r.='								</select>';
		
		$r.='								<a href="#" onclick="openbar(\'\'); return false;"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACYAAAAnCAYAAABjYToLAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABx0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzIENTNui8sowAAAE0SURBVFiF3dhLjsIwDIBhM5o9B+Bso0gVr7PBisOxQ/pZEEOmYpLGTYo1lrygau2vJGrTrADxGF+j32sRGT7gGGLvVwCa38AJuAIhOd47Q+x5igYBJEVd+B3bBVDbUc+L4gTYAGfeR0/cGKVxBjb6V+aiB+4vlEZIxzkXu4aoXQlFMscE2C+AK6H2eq75QkNW3bilgAVXXbNZoZaoHKwVzlyjVPgwA1dCHXK9pwxFCfeugeWaalhto9moGtiUhj8xZ6NqYVNwTVAWmBVXhbLCBDhWoI6WHlaY8JhPtwzoFs8x1R8vrf3EfxpKl5Pf5ePC5QPW5SvJ5Uvc5bLH5ULR5dLa5ceIy8+3nqipPZ44vSDU3E1nXFBYCfWxTRW321CC0427FOduq1NzDQwLojSH2Pt57A6HxtlxOOnGGAAAAABJRU5ErkJggg=="/></a>';
		$r.='							</span>';
		$r.='						</p>';
		$r.='						<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>';
		$r.='						<div>';
		$r.='								<canvas id="line-chart" height="50px"></canvas>';
		$r.='						</div>';
		$r.='					</td>';
		$r.='					<td width="2%"></td>';
		$r.='				</tr>';
		$r.='		</tbody>';
		$r.='	</table>';
		$r.='	<script>';

		$r.='			function historylog(v){';
		$r.='						if(v==\'All\'){';
		$r.='								new Chart(document.getElementById("line-chart"), {type: \'line\',';
		$r.='								options: {title: {display: false}},';
		$r.='									data: {';
		$r.='										labels: [';
															foreach ($this->objectTimer as $key => $value) { $r.='"'.$value->datetime.'"'.','; }
		$r.='],';
			$d='';					
			$d.='											{ ';
			$d.='												data: [';
																foreach ($this->objectTimer as $key => $value) { $d.=$value->systemload.','; }
			$d.='												], label: "System Load",borderColor: "#3e95cd",fill: false';
			$d.='											},';
			$d.='											{ ';
			$d.='												data: [';
																foreach ($this->objectTimer as $key => $value) { $d.=$value->request.','; }
			$d.='												], label: "Request",borderColor: "#e8c3b9",fill: false';
			$d.='											},';
			$d.='											{ ';
			$d.='												data: [';
																foreach ($this->objectTimer as $key => $value) { $d.=$value->twigtime.','; }
			$d.='												], label: "Twig",borderColor: "#8e5ea2",fill: false';
			$d.='											},';
			$d.='											{ ';
			$d.='												data: [';
																foreach ($this->objectTimer as $key => $value) { $d.=$value->framework.','; }
			$d.='												], label: "Framework",borderColor: "#3cba9f",fill: false';
			$d.='											},';
			$d.='											{ ';
			$d.='												data: [';
																foreach ($this->objectTimer as $key => $value) { $d.=$value->appload.','; }
			$d.='												], label: "App",borderColor: "#5fcf80",fill: false';
			$d.='											}';

		$r.='										datasets: [ '.$d.' ]}';
		$r.='								});';
		$r.='						}';
			
		$r.='			}';
		$r.='	</script>';

			
		return $r;
	}

	public function showBar(){

		$r='<div class="sdbrdt">';
		$r.=	$this->getExecutationTime();
		$r.=	$this->getRamMemory();
		$r.=	$this->getErrorsLog();
		$r.=	$this->getHistoryTime();
		$r.='	<table class="mntb">';
		$r.='		<tbody>';
		$r.='			<tr>';
		$r.='				<td>';
		$r.='					<a class="icbr">';
		$r.='						<img  src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACYAAAAnCAYAAABjYToLAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABx0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzIENTNui8sowAAANPSURBVFiFzZjJb01RHMc/fa2ooalWOogEqakhYoihqbESJCQ2TUiIFRKSYsneHyAWFoaNxoZYWLGgIrEwhyYaQ6ghRWJWLVp9vhbnvLq9vffcQZ/6Jjc559zf+Z3v+433PCSR8imWtFvSTUm9+oNeSbcl7ZFUklZ/WlI77eHfFY4fklotwcJ8E6uQdNFBJgzXJE1KclaBJGKiFLgKzIm7wYd2YAXwKo5wJoHik6QnBVADnAEKYknHNG1jCveFYe9QubIQaAVm+9bfA1eAO8Bz4B3QDYwEKoBZGNcts2s5vAWmAl1/a7EVvl/8XtIBSZskHZK0NWL/dEmHJWU9OrZEnRtFKiPpgkfhdUnrJTXbeY+k/XFcI6le0jO777ak0rTESiW1eEj1WVKPJHXKFNekBXSDR1+bpJow2SKHl6cDqz3zX0A5MAPYBpxyxkgwuj3jXAy2Bwm6ysUvx7vYxS/ivJ9xBV0oALJ2nHUJOhB7XxJiRZiysAa4ECJTbeWCMB44mA9iYEx/CfjiWx8FnAYeA/cY3CEagQfActwhEotYYcBaWDvZAWwCSjCFuBnYDhwFOoCzltg+374RYYe7srIDY5lSz9rXENkq33wecALoxHSHJuAcxpJeYzwMPT2i7mz2VezjkqoD5CZLemllspKaJFUFyB3x6DroOjtOr7wCrPTMPwHngRbgLvAG0/+qMHXvKXDDypYBk4F6TO2rs+sddj003lyuzOGDb14GbLUPGHd9Bj4C3zBxMwaTEOUMDIUculykgEhXNkh6raFHt0yYpHJlBmgDaiNtmg4fMO7sDnrpKhfCpH++MBrj7kC4iE0ZcioD0QNMCHsZRKwMOAbcBybmiRTAOEz2NmNa2QD4Y6wSuMzgz+h84wWwCtOLgcEWO8K/JwUmCZrxtDyvxWqAJ8S9XuUHddji7LXYUoaXFEBDbuAlVj8MRPxYnBt4W9KSBApuYQI2qqVlMW2pIUIuh/lWZ1+uBVTL/c+NHxtd7cT3TEugNytzD+135VygOIHFQit2AMYmkM1YLv3EkrgRkiVJ0oRaCH+ILUq4OZ9YAIZYNeby+b9gJjApA6zD0UxDkPbCGweVwNoMsItkwQz5LcTFwI7+LEiIsNvSUKH2NxkQZDtDXG2wAAAAAElFTkSuQmCC">';
		$r.='						<span>v'.\Kernel::getInstance('Kernel')->version().'</span>';
		$r.='					</a>';
		$r.='				</td>';
		$r.='				<td>';
		$r.='					<a class="icbr">';
		$r.='						<img  src="data:image/png;base64,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">';
		$r.='						<span>'.$this->response.':OK</span>';
		$r.='					</a>';
		$r.='				</td>';
		$r.='				<td>';
		$r.='					<a class="icbr"  onclick="openbar(\'speed\'); return false;">';
		$r.='						<img  src="data:image/png;base64,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">';
		$r.='						<span>'.$this->executationTime['systemload']['time'].'ms</span>';
		$r.='					</a>';
		$r.='				</td>';
		$r.='				<td>';
		$r.='					<a class="icbr" onclick="openbar(\'sql\'); return false;">';
		$r.='						<img  src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACYAAAAnCAYAAABjYToLAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABx0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzIENTNui8sowAAASVSURBVFiFzdjZbpZVFMbx3/sVKVA7QaWiCE6AGsXggMY4XICnnnkBauKhl2Kih5545k2IJE4IBo0DShSQWYVSrZ23B2vtvB8dLDXadiU7bb53evb0X89eTSnFRoxNK1zvx0Hsx17swZ3Yjh15/TZsyQaT2WYwjt/xGy7hLM7gFE7m9SWjWTBi2/Ag7sXd2IXRFDGMwRSzNe/tRSc7eFu+YwazmMM0/sJEihjDtRR6GRey/Ywf876bhA3jGTyFJ/EY7suP3mrUHjareGYeP+ErfIFj+BTXmlLKk3gRr2PfKl/8X0bBD3gXHzallE9xF3avk6CFcQ4XOuixuin7v6MHPU0p5bB2Kh9YX01Oi6k8Uhf/IF7A03gCj4qduRbxM77GcXyOjzDWlFIO4Bf8KYbxIB4W3NqNnQIXgxbjomeFj85ZjIsxgYsr+d0z+FZwbQ592N2UUt7Li5+JrXvOzeDbI3i2EyMCLf3ZtmgZtjnvn9aybDLfNS749WsKuihgW6Mf9whEHcbepsRczgvQfZ5D+g3OZ+8m8gNT2abz/tVEJ4X3ZtsiRnxQgPwRsYSeFoToVGE1ZrPVdHJWrIFL2a5mz8dwQ0xT9zPE6G3KthUDKWAYd4iUdqdYw3u0aa0+gyD/Slm85r3uVFPbvABjHfU6Ok22iqPa6rTX/Lps3IqwdYmOSKYTK924hjGBy00p5TWxE14R62E94wY+wGcVsPvxqnAYe8VO6V8jMeOCAGeEs3gfp5pSykAqJYD6fAo8INjVJ3ZXNYO9YvGuBNcac2LjTGlN5F8C6FfwfQo6KoALA00p5S1hN44JDNTdt1mYxAcE/HaJbd6dBbaJnbbZzUZxOt8xkZ2+rnWxFwXET4v1Pa3drYPCE+5rSim/5wtO4eNUfzIfmtHypXvrN1pXUrFQHcq8FiPzOWL1/9muv7MpZlSkwcN4TiyrbQtx8Zvw6GMifVSPfimFXs3ej4m1MWn5LNARU9+fIzEkADuaI1/PECNaAI/Uh1fi2FQKGRdrYkKsj5qeZrpGYC6fqSDt5IjUNFQTf1+KHcrfl4wNDdh/mo71iHlMbhLceAjPunUE/F8xJzbgd00ppU+w600cEvPfZ+1Ezon1O44TeBtHK/kbwalHhf9/VrjYAS0mOl1ttUe8iovaqjO5IdzrJzgiLPZFlKaU8rI4BX+fL9khSgDbRSa4V6SoUbHdt6fgfi1gu73UbFerlvqGwNBVgZ3zwuf9kr/XMgKRcR5sSinH88cTwr1+ie+6etur9fpVTE1PNTVVRFRh1a/NaNNQFVm9/1TXNx7C46IKcAg7unExlSN3Wh46tc619uo6/rB6m7QNtwt21dmoTvYukfLuF5WAXlbm2JUU+GsKuyam5c8UOKW11d3Wulrl3hTUJ6Z/OEWNpKCdy314QwN2Iworm8R5cpdIqBshzuJCU0o5hJfwho1RhnpHlqFYXLg7KE7FqxH5bwp3RZz+T1qicNd9Yy113mdxqXPIf1PqrG72sqD8+RS3ZKlzuRgSZc99wtjdY3FxuB79u4vDtZSwsDh8ThjPH0R58/pyH/4bwHjBHZCD1QQAAAAASUVORK5CYII=">';
		$r.='						<span>'.$this->sqlRecords.' SQL</span>';
		$r.='					</a>';
		$r.='				</td>';
		$r.='				<td>';
		$r.='					<a class="icbr" onclick="openbar(\'ram\'); return false;">';
		$r.='						<img  src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACYAAAAnCAYAAABjYToLAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABx0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzIENTNui8sowAAAUdSURBVFiF1ZhLbBVlFMd/99LSllJaqIBCS31AQGwl1pUxqSTGFwKJGhay0IUmPpbudKEujBoXmpi4MQGNLowSExLfkvgILDDGFAVBg6BoSQsIYi3cPu/fxTkf83XunXtriq2eZDJz/3PmzP87c17fRRJljmskfSRpj6SbHLtB0peSdkla59jtkr6StFPSlY7dK6lX0puSFjv2qKQDkl6RNM+xJyQdlPSspNo0hxrKSx3QDiwAGhxrAFYAI0C9Y/OBDmAOUOvYAtc7AxfstwBtwFIg71irY5cAuTSBLGKBRJO/KCYxAsxzrDl6WSC7yI+2iOxi123zRQBc6vaXRWQvSAkQiTKwLHwqMuVns4jFBJTCKt2bLlaVWC66l09heZKYiHUuBlaV2BySmAkxUeMG6kliM5zrI1sBq4teWFsFK5Gs4P8FeM5f+K1jB4HngXHgJ8e+Bl7EMrDfsS+Al4FjwFnHPgCKwPdAwbF3gJPAXrc5SXLSVON2ZiXtsQVYajdEWI7E/UU/h88WAjfW+acYwATwF+bB0TSxDuAuYDNwBTB36uublhSdVC/wFvA5cC60gHZJr0oakDSh2ZGCrEXdJ6m5Bqvcm4FNfj1bUg9cDWwBWmuA5cCtwJJZJBXL9UBHDdYD27CAPgL8AAwxOUgbgJXYigQcAI5ifTMujk3AWixeC1ipOY6VgxxlCikWY3nMMeuwr9aKpPWS9vt3fkHSIkk5JSNITlKTpMdk8VeQ9JCkRk0eVfKSlshGG0k6Juk2SXUpvTmSalJYraRu2QglSUqXi1+xYgmw0Ff4J5Y1R9xbReAwcA7L6mYs3c9i6d7nzxeAH0nGpCZg2G2BTSjz3c454BBJQS5pSaFOXQu8B3wGrHdsLNKb8PNGrNK/C6xK2Yj1HgF2Yx2h0bHHgT3AM+6ACaJmnvZYILoIuNGvQ1KEthHHSjvQ6UabUzbieFoFrMY8FnrkWse7/BnFz2T1ysO+okZs+nwQuNkNTEQGdmM99Q+sN6Yl6A37+TyJRwsRNolUJWLHsYYN8DTwVHQvJrbPj2qSi865DGxS004TC6tpwNw8FysdH2Kf4io3EvQWut4wVmZGo3uKrsthSmH5CCsJ/vC7E9gJfIxl2Z2Y14okcxnABuAT4G2szqVtpofCXJl75bASj7UBlzmxsJlox5KhyVeUdxKHsABucb0urLQsc1uhxYTiCRazncBpzNtgSdPpXMLGh5ykHuAloBsbAI9io0+XKx/EvLbciYSBbwCr8KuxWnUAq4ErsenkPPAdFgprfKGDjo25raVOcr8voMuJjuckdWOfaSOVd00zJf3A73ksAz/FqvZ/Qb4BXs8DJ7Aq/75fFys99S/KMBa3O4Dt8cx/OTbBbmJmJ1hROsEOpTcjszHzhz45SDTz/292SUFWAA9gtegNrDysAe7Hmvl24Gds2tyKlYltWAnpAe7Beuc2rLZtAO5wO69h5WULNrnsxT7h5L2lyv8/1iNp1Ge2rY7dHW0cbnHsYf89KOk6x56MBsUOx8Lw2CupxbEdju2SVJ/mkFW3JkgmgjBTjWMxMRytLpyHSeIvYCMkvW+sClYilf7tyWrAxch4rHMxsKrEKo0nle5NF6tKLH4wi3A13Sybae+UfTYrKwtYVrWQbB6GHBvBGjRYxp3AmnyIyTN+9JHE0SnX7SP5hANuu58y3SaL2IgbGYxIFLBd1BhJwA451h+RGAR+cywkwlm3dzIicRrr06coE2N/A8gmY9HisEffAAAAAElFTkSuQmCC">';
		$r.='						<span>RAM '.$this->ramMemory['memorypeak']['time'].'mb</span>';
		$r.='					</a>';
		$r.='				</td>';
		$r.='				<td>';
		$r.='					<a class="icbr" onclick="openbar(\'history\'); return false;">';
		$r.='						<img  src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACYAAAAnCAYAAABjYToLAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABx0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzIENTNui8sowAAAHBSURBVFiF7djPahRBEMfxz6xxQ0QhsAYNqJiTigdFzcGDoJc8gOALiHjXN1H04sV7niJ4FkR8ATGCgp4SSdyN2B66FzfDmNnJOuMI84Nh/lR18+2erprqyUII2qjeDG3P4Sl2EHLHNp4kn8bBVnEDRwts/WRfPWzns4Ct4SbmCmz9ZFs7bOezgM3/JZ9CzQJWqzqwqurAqqoo1OvSIq7hdO55hi28xaaYoBsDm8c9PMLFAvtXvMRzfKC5VznAfVwSZyh/LCX7lXGDpsD6OFXicxLHxzdNLv6yMubn5E1ro7IDq6rWguXz2IIYHUXF346Yb37UDcV+sEXcxQMxtCejKOAdnmFDLoLqBruKx7j8B98VvwG/1My1b40tHwAFR0T4Y7USJeUX/zSvKKsDJK/WRmUHVlUdWFV1YFX1X4B9N12VuZuuR1P0P/bZVZ68Q2JA/Fb2xF3MWeVZvY8L6TyYAmyQ+l1JbQ5SlnwXMMxCCLdwGw9xpqTxHj5hKO4PT5T4b+OzOPBlxeXUpD7iBTayEMIrnE+0bdAm3mchhG/iNJeNpintYTQn/ke9jjv+PdxQLETf9LCO16aLsro1ElnWfwF13FFAbmwKTwAAAABJRU5ErkJggg==">';
		$r.='						<span>history</span>';
		$r.='					</a>';
		$r.='				</td>';
		$r.='				<td>';
		$r.='					<a class="icbr" onclick="openbar(\'errors\'); return false;">';
		$r.='						<img  src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACYAAAAnCAYAAABjYToLAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABx0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzIENTNui8sowAAAUUSURBVFiFzdhryJ51HQfwz/089+5tbmOewOEhy/BEZqVzZlpBRRpYIKTiAbLeDMTyTQS9CAbZi1DCyhfSigKVbBZEMKesZCmTpCnzME8DN6U5sWk7uM0987l/vfj9r+6r2/u6D88D4hcu7v91/Q/39/r9f4fv/2pFhA8jpvAp3IZ3EBNcB/ELfKSs1cKleATdMea/h7uxtInY1ViJzoQv1cFFWFXul+LL+NgYc/fiz9iAIwNHRMQ7EXEk5o61ESEiTouIbSPGvhcRWyNiTUScW+YNvNpYMqGl+rGw/E5h0ZBxb+Ex/Aob5VY2oj1PUv1oiqRXcW8h9RoWYDEOf1DE+tHFU/gZHsQ+rMBlpb3xgyLWqrVn8RBul1vYxdewGu/KiGxEG4dkhM2V5Ez57dbaB/FH3ImtOAnfwTdxgdzWbaOI/Vami4vnQOpFPFraB+R2zWIT7sBOfBbfLqSOL2O349+jiN1eSF0uo6pKgK0B4+vPj+DvWF/u90vn/gc243V8HTeXtevz3h7+vjTmkXleiyLixojYMiCX7Y2I1aPWaJc3WYrlMhfV0ZXRc6D2rCW3ZEkZ35LlbE+x6CLchFtxzgBbLDZGlWnjEllKrtVLlhVm5FatlX4xLUP9FlljO9JX7sVdheS38L0GUsqcZaOIiYi/RcQrQ8rI2xHxw2LiEyPigYg4Wuu/PyLOjIgFEXFdRDw9ZK0KP4+IJcO2UkR0yzUM90SvHm6vPV8XEWeXvksj4vExSEVErI+Ii4YRq3xkUATW0ar9Vu0n8Gu8JBXFLVJtjIML8LlhA/qdfRxMyVz1e6m9jsE3cKXxk/QKfFFPy82b2JRe/dssFcIq3GhylXIxrtegSCYlNi0jdQOeL4teJremyR1mZCo52vf8ZJkJPj9o7ly2ci/+KWvsSnxpxDqv4B6Ds/0n8QNcOF9i70pL7S73dWk9CIeltFknE3U/pvEF/Aif6Cd2yPvN3I+6anhCqtFjcZ7hvvUc7pPicH/DmA6ukEn5f+eFKfwGW4Ys/qJUCxWxjXhDZv6PD5lHBsee8vsvzXK6g2vKtZwM7zvkdnxVlqRKHrekEnhUOjtp2Z2lfY7mcJ+V1vqLtPYMXpY197iGOcfiBqnfHp6PgvhJRBxuyOzPR8RVtbGdiLg2InaMURVui4gVlbpYVhgPCoYq27el8+8qFjne4BzULZbaVHs2I/PeS/hog8UqXIjr2/L0XKmLSijWUd13sEMmxV0NpEKqkE34T1/fbvyhEDt7CLGzsLCNH8toOH3Em5BWW1zagxx5Bn+VKaUfs/gTTsB3NfvnSVjeljVrVBGv/3Glpd6SwbCg1n9UppNdDfP343fl/1YbHNUL0a7Uxbjo4LQyZ6deoq3QlVp/dsgae+QBaH1D/wHsnjTzL8K50mrb9FLHpNgjy9qgDyqvYfOkxI7BZ2QEb5WOXkdL+tA42Gdw/Xwa901KbCHOx4nS5M/KklZhGmdI4qPQ9f5S+KYMng1zURen6oX743oHXnrfzE4dY52O//9od1AeejYwN9mzGF+R+WiLVA5vlr4qyleOsc5xepbdJ09Za6X/zfnD3euRB1oRcUJE3BoRz9X6H46IVdFczpZHxE/L2B0R8f2IOLk+ZnrNmjVLZHScLn1kHCyTKuBVvCB9bbtMFYekOq36B32juEQq12fwS9yvLxCm8ACe1NNc42KVjFCFzIPy09JGWY7Ox6cb5p4iI3idrAYH+wf8F67WLV9d5iCyAAAAAElFTkSuQmCC">';
		$r.='						<span>'.$this->errorsRecords.' errors</span>';
		$r.='					</a>';
		$r.='				</td>';
		$r.='			</tr>';
		$r.='		</tbody>';
		$r.='	</table>';
		$r.='</div>';
		$r.='<style>';
		$r.='	.sdbrdt table.mntb { width: 100%; font-size: 12px; font-family: monospace; position: fixed; left: 0px; bottom: 0px; text-align: center; background: #333; color: #ddd; border-top: 1px solid #393939;  } .sdbrdt table.mntbopen { width: 100%; height: 150px; font-size: 12px; font-family: monospace; position: fixed; left: 0px; bottom: 35px; text-align: left; background: #444444; color: #ddd; border-top: 1px solid #444444;  } .icbr{ height: 18px; padding: 5px 0px; display: block; background: none; cursor: pointer; text-align: center} .icbr:hover,.icbractive{ background: rgba(100, 100, 100, .2); } .icbr img{ height: 17px;  } .icbr span{ margin-left: 10px; position: relative; top:-3px; color:#ddd; } .clbr{ width: 10px; height: 15px; background: #333333; display: block; float: left; margin-right: 5px;} .clbr1{ background: royalblue;} .clbr2{ background: salmon;} .clbr3{ background:springgreen;} .clbr4{ background: teal;} .clbr5{ background: slateblue;} .mntbopen{ display: none;} .mntbopen p.titlebar{ font-size: 18px; margin: 0px; color: #FFFFFF; margin-bottom: 8px;} .mntbopen p.titlebar img{ top: 1px; position: relative;} .scllcd{ height: 145px; overflow-y: scroll; background: #333; border-radius: 3px; padding-left: 10px;} .scllcd code{ font-size: 10px;} .headerbarcomands{ float: right; width: 100px;} .headerbarcomands a{ float: right; margin-left: 10px; background: rgba(10,10,10,.2); padding: 0px 5px;} .headerbarcomands img{ width:12px;} .sdbrdt ::-webkit-scrollbar { width: 8px;} .sdbrdt ::-webkit-scrollbar-track { background: #f1f1f1;  } .sdbrdt ::-webkit-scrollbar-thumb { background: #888; } .sdbrdt ::-webkit-scrollbar-thumb:hover { background: #555;}';
		$r.='</style>';
		$r.='<script>';
		$r.='	function openbar(status){';
		$r.='		document.getElementById("speedID").style.display=\'none\';';
		$r.='		document.getElementById("errorsID").style.display=\'none\';';
		$r.='		document.getElementById("ramID").style.display=\'none\';';
		$r.='		document.getElementById("historyID").style.display=\'none\';';
		$r.='		if(status==\'speed\'){';
		$r.='			document.getElementById("speedID").style.display=\'table\';';
		$r.='		}';
		$r.='		if(status==\'errors\'){';
		$r.='			document.getElementById("errorsID").style.display=\'table\';';
		$r.='		}';
		$r.='		if(status==\'ram\'){';
		$r.='			document.getElementById("ramID").style.display=\'table\';';
		$r.='		}';
		$r.='		if(status==\'history\'){';
		$r.='			document.getElementById("historyID").style.display=\'table\';';
		$r.='			historylog(\'All\');';
		$r.='		}';
		$r.='		sessionStorage.statusBar = status;';
		$r.='	}';
		$r.='	if(typeof sessionStorage.statusBar!="undefined"){ openbar(sessionStorage.statusBar); }';
		$r.='</script>';

		echo $r;
   	}
}