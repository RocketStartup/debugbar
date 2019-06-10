<?php

namespace Astronphp\Debugbar;

class ExecutationTime{

	public $instance 	= '';
	public $serverName 	= '';
	public $requestUri 	= '';
	public $page 		= '';
	public $datetime 	= null;

	public $systemload 	= 0;
	public $framework 	= 0;
	public $twigtime 	= 0;
	public $appload 	= 0;
	public $request 	= 0;
	public $timer 		= null;
	
	public function __construct(){
		$this->timer	=	\Performace::getInstance('Timer');
		$this->timer->register('systemload',	microtime(true));
		$this->timer->register('appload',	microtime(true));

		$this->serverName 	= $_SERVER['SERVER_NAME']; 
		$this->requestUri 	= $_SERVER['REQUEST_URI']; 
		$this->datetime 	= date('d.m H:i'); 

		$this->systemload 	= $this->timer->get('systemload')[0]['time'];
		$this->framework 	= $this->timer->get('framework')[0]['time'];
		$this->request 		= $this->timer->get('request')[0]['time'];
		$this->twigtime 	= $this->timer->get('twig')[0]['time'];
		$this->appload 		= $this->timer->get('appload')[0]['time'];
		if(isset($this->timer->get('twig')[0]['time'])){
			$this->appload		= 	$this->timer->get('appload')[0]['time']-$this->timer->get('twig')[0]['time'];
		}else{
			$this->appload 		= $this->timer->get('appload')[0]['time'];
		}
	}

	public function instance(){
		
		$this->instance['systemload']['name']	=	'Execution Time';
		$this->instance['systemload']['time']	=	$this->timer->get('systemload')[0]['time'];
		$this->instance['systemload']['color']	=	'#4169e1';
		$this->instance['systemload']['percent']	=	null;

		//request server
		$this->instance['request']['name']		=	'Request';
		$this->instance['request']['time']		=	$this->timer->get('request')[0]['time'];
		$this->instance['request']['color']		=	'#6a5acd';
		$this->instance['request']['percent']	=	number_format((100/$this->timer->get('systemload')[0]['time'])*$this->timer->get('request')[0]['time'],0);

		//request framework
		$this->instance['framework']['name']	=	'Framework';
		$this->instance['framework']['time']	=	$this->timer->get('framework')[0]['time'];
		$this->instance['framework']['color']	=	'#008080';
		$this->instance['framework']['percent']	=	number_format((100/$this->timer->get('systemload')[0]['time'])*$this->timer->get('framework')[0]['time'],0);
		   
		//request twig
		$this->instance['twigtime']['name']		=	'Twig';
		$this->instance['twigtime']['time']		=	$this->timer->get('twig')[0]['time'];
		$this->instance['twigtime']['color']	=	'#fa8072';
		$this->instance['twigtime']['percent']	=	number_format((100/$this->timer->get('systemload')[0]['time'])*$this->timer->get('twig')[0]['time'],0);
		
		//request appload
		$this->instance['appload']['name']		=	'App';
		$this->instance['appload']['time']		=	$this->timer->get('appload')[0]['time'];
		$this->instance['appload']['color']		=	'#00ff7f';
		$this->instance['appload']['percent']	=	number_format((100/$this->timer->get('systemload')[0]['time'])*$this->instance['appload']['time'],0);

		return $this->instance;
	}

}