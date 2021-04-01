<?php

declare ( strict_types = 1 );

/*
	@ Author: MouseZver
	@ Email: mouse-zver@xaker.ru
	@ php-version 7.4
*/

namespace Nouvu;

final class Container
{
	private array $container;
	
	public function set( string $name, callable $func ): void
	{
		if ( isset ( $this -> container[$name] ) )
		{
			throw new \Error( $name . ' already exists!' );
		}
		
		$this -> container[$name] = $func;
	}
	
	public function get( string $name )
	{
		if ( ! isset ( $this -> container[$name] ) )
		{
			return null;
		}
		
		if ( $this -> container[$name] instanceof \Closure )
		{
			$this -> container[$name] = $this -> container[$name]( $this );
		}
		
		return $this -> container[$name];
	}
}
