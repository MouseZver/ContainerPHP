<?php

declare ( strict_types = 1 );

namespace Nouvu\Container;

use Psr\Container\ContainerInterface;
use Closure;

final class Container implements ContainerInterface
{
	private array $container = [];
	
	public function set( string $offset, Closure $closure ): void
	{
		if ( $this -> has( $offset ) )
		{
			throw new ContainerException( "Such an entry already exists for '{$offset}'" );
		}
		
		$this -> container[strtolower ( $offset )] = new DI( $this, $closure );
	}
	
	public function get( string $offset ): mixed
	{
		$this -> has( $offset ) ?: throw new ContainerException( "No entry or class found for '{$offset}'" );
		
		return $this -> container[strtolower ( $offset )] -> get();
	}
	
	public function has( string $offset ): bool
	{
		$name = strtolower ( $offset );
		
		return isset ( $this -> container[$name] ) || array_key_exists ( $name, $this -> container );
	}
	
	public function make( string $name, array $params = [] ): mixed
	{
		try
		{
			return $this -> get( $name );
		}
		catch ( ContainerException )
		{
			$this -> set( $name, fn( ContainerInterface $ContainerInterface ): mixed => new $name( ...$params ) );
			
			return $this -> get( $name );
		}
	}
	
	public function reset( string $offset ): bool
	{
		if ( $this -> has( $offset ) )
		{
			$this -> container[strtolower ( $offset )] -> reset();
			
			return true;
		}
		
		return false;
	}
}
