<?php

declare(strict_types=1);

namespace Returnless\InertiaTypescriptGenerator\Tests;

use Returnless\InertiaTypescriptGenerator\Iterators\AbstractAttributeIterator;

final class DummyAttributeIterator extends AbstractAttributeIterator
{
    protected function getIterable(): array
    {
        return [
            'Returnless\\InertiaTypescriptGenerator\\Tests\\Stubs\\' => __DIR__ . '/Stubs',
        ];
    }
}
