# Nouvu/Container DI - Lazy loading
[![Latest Unstable Version](https://poser.pugx.org/Nouvu/container/v)](https://packagist.org/packages/nouvu/container) [![License](https://poser.pugx.org/nouvu/container/license)](https://packagist.org/packages/nouvu/container)

### Composer

```sh
composer require nouvu/container:^2.1.2
```

## Examples ##

```php
use Nouvu\Container\Container;
use Psr\Container\ContainerInterface;
 
require 'vendor/autoload.php';

class TestClass
{
    private int $int = 1;
    
    public function add(): void
    {
        $this -> int++;
    }
    
    public function get(): int
    {
        return $this -> int;
    }
}

//---------------------------------------

$container = new Container;

$container -> set( \Test :: class, function ( ContainerInterface $Container ): TestClass
{
    return new TestClass;
} );

//---------------------------------------

$test = $container -> get( \Test :: class ); // TestClass

$test -> add();

echo $test -> get(); // 2

$container -> reset( \Test :: class ); // reset class

$test = $container -> get( \Test :: class ); // new TestClass

echo $test -> get(); // 1
```