<?php

declare(strict_types=1);

namespace Returnless\InertiaTypescriptGenerator\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final class Typescript
{
    public function __construct(
        public string $viewModel,
    ) {}
}
