# Typescript Generator

This package allows you to generate typescript types from your PHP classes.

### Installation

```json
{
  "require": {
    "returnless/inertia-typescript-generator": "dev-main"
  },
  "repositories": [
    {
      "type": "git",
      "url": "https://github.com/Returnless-com/inertia-typescript-generator.git"
    }
  ]
}
```

## Usage

### Using attributes

```php
class DummyClass
{
    protected string $viewPath = 'my-view-path';

    public function myMethod(): string
    {
        // ...
    }
}

#[Returnless\InertiaTypescriptGenerator\Attributes\Typescript(DummyClass::class)]
class MyController
{
    // ....
}
```

```shell
php artisan inertia-typescript:generate
```
