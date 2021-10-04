<?php

declare ( strict_types = 1 );

namespace Nouvu\Container;

use Psr\Container\ContainerInterface;
use Closure;

final class Container implements ContainerInterface
{
	private array $container;
	
	public function set( string $name, Closure $closure ): void
	{
		/* if ( isset ( $this -> container[$name] ) )
		{
			throw new \Error( $name . ' already exists!' );
		} */
		
		$this -> container[$name] = $closure;
	}
	
	public function get( string $name ): mixed
	{
		$this -> has( $name ) ?: throw new ContainerException( $name );
		
		if ( $this -> container[$name] instanceof Closure )
		{
			$this -> container[$name] = $this -> container[$name]( $this );
		}
		
		return $this -> container[$name];
	}
	
	public function has( string $name ): bool
	{
		return isset ( $this -> container[$name] ) || array_key_exists ( $this -> container[$name] );
	}
	
	public function make( string $name, array $params = [] ): mixed
	{
		if ( $this -> has( $name ) )
		{
			return $this -> get( $name );
		}
		
		$this -> set( $name, fn( ContainerInterface $ContainerInterface ) => new $name( ...$params ) );
		
		return $this -> get( $name );
	}
}
