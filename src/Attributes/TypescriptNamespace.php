<?php

declare(strict_types=1);

namespace Returnless\InertiaTypescriptGenerator\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final class TypescriptNamespace
{
    public function __construct(
        public string $namespace,
    ) {}
}
