<?php

declare ( strict_types = 1 );

namespace Nouvu\Container;

use Psr\Container\ContainerInterface;
use Closure;

final class DI
{
	private bool $return = false;
	
	private mixed $instance;
	
	public function __construct ( private ContainerInterface $container, private Closure $closure )
	{}
	
	public function get(): mixed
	{
		return $this -> instance ??= ( $this -> closure )( $this -> container );
	}
	
	public function reset(): void
	{
		$this -> instance = null;
	}
}
