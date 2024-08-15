<?php

declare(strict_types=1);

namespace Returnless\InertiaTypescriptGenerator\Writers;

final class ConsoleWriter implements WriterInterface
{
    /**
     * @param  class-string  $attribute
     */
    public function write(string $attribute, string $contents): string
    {
        return $contents;
    }
}
