<?php

declare(strict_types=1);

namespace Returnless\InertiaTypescriptGenerator\Tests\Stubs;

final class TestStubViewModel
{
    public string $name = 'Foo';

    public bool $isBar = true;

    protected string $viewPath = 'view-path';
}
