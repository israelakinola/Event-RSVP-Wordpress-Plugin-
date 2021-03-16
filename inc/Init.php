<?php
/**
 *  @package zain
 */

namespace Inc;

class Init{
    
    public function get_classes() 
	{
		return [
            Utility\AdminPages::class,
            Utility\CustomPost::class,
            Utility\EnqueueScript::class,
            Utility\ApiRoutes::class,
            Functions\Event::class,
		];
	}
 
    public function run(){
        foreach($this->get_classes() as $class){
            $service = new $class ;
			if ( method_exists( $service, 'run' ) ) {
				$service->run();
			}
        }
    }
}