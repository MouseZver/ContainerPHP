<?php

declare ( strict_types = 1 );

namespace Nouvu\Container;

use Psr\Container\ContainerInterface;
use Closure;

final class Container implements ContainerInterface
{
	private array $container = [];
	
	public function set( string $name, Closure $closure ): void
	{
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
		return isset ( $this -> container[$name] ) || array_key_exists ( $name, $this -> container );
	}
	
	public function make( string $name, array $params = [] ): mixed
	{
		if ( ! $this -> has( $name ) )
		{
			$this -> set( $name, fn( ContainerInterface $ContainerInterface ): mixed => new $name( ...$params ) );
		}
		
		return $this -> get( $name );
	}
}
