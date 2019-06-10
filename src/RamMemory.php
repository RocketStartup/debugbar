<?php

namespace Astronphp\Debugbar;

class RamMemory{

	public $instance 	= array();
	
	public function __construct(){	}

	public function instance(){
		$this->base_memory_limit 	= log((int)ini_get('memory_limit')*1024*1024, 1024);
		$this->memorylimit        	= round(pow(1024,$this->base_memory_limit-floor($this->base_memory_limit)),2);

		$this->memorypeak        	= round(memory_get_peak_usage(true) / 1048576, 3);
		$this->memoryusage        	= round(memory_get_peak_usage() / 1048576, 3);
		$this->memoryusageSystem 	= round(memory_get_usage() / 1048576, 3);

		//peakemalloc
		$this->instance['peakemalloc']['name']			=	'Peak emalloc';
		$this->instance['peakemalloc']['time']			=	$this->memoryusage;
		$this->instance['peakemalloc']['color']			=	'#4169e1';
		$this->instance['peakemalloc']['percent']		=	(100/$this->memorypeak)*$this->memoryusage.'%';

		//usegeserver
		$this->instance['usageserver']['name']			=	'Usage';
		$this->instance['usageserver']['time']			=	$this->memoryusageSystem;
		$this->instance['usageserver']['color']			=	'#6a5acd';
		$this->instance['usageserver']['percent']		=	(100/$this->memorypeak)*$this->memoryusageSystem.'%';

		//memorypeak
		$this->instance['memorypeak']['name']			=	'Peak';
		$this->instance['memorypeak']['time']			=	$this->memorypeak;
		$this->instance['memorypeak']['color']			=	'#008080';
		$this->instance['memorypeak']['percent']		=	null;

		//memory_limit
		$this->instance['memorylimit']['name']			=	'Limit system';
		$this->instance['memorylimit']['time']			=	$this->memorylimit;
		$this->instance['memorylimit']['color']			=	'#00ff7f';
		$this->instance['memorylimit']['percent']		=	null;
		
		return $this->instance;
	}

}