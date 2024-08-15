<?php

declare(strict_types=1);

namespace Returnless\InertiaTypescriptGenerator\Writers;

interface WriterInterface
{
    /**
     * @param  class-string  $attribute
     */
    public function write(string $attribute, string $contents): string;
}
