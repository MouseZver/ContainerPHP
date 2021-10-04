<?php

declare ( strict_types = 1 );

namespace Nouvu\Container;

use Psr\Container\NotFoundExceptionInterface;

class ContainerException extends \Exception implements NotFoundExceptionInterface
{
	
}