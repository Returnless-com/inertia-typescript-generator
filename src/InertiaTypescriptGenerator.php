<?php

declare(strict_types=1);

namespace Returnless\InertiaTypescriptGenerator;

use Generator;
use Returnless\InertiaTypescriptGenerator\Iterators\AbstractAttributeIterator;
use Returnless\InertiaTypescriptGenerator\Writers\WriterInterface;
use Returnless\TypescriptGenerator\TypescriptGenerator;

final readonly class InertiaTypescriptGenerator
{
    public function __construct(
        private AbstractAttributeIterator $attributeIterator,
        private WriterInterface $writer,
    ) {}

    /**
     * @return \Generator<string>
     *
     * @throws \ReflectionException
     */
    public function generate(): Generator
    {
        $typescriptGenerator = new TypescriptGenerator;

        /** @var class-string $typescriptAttribute */
        foreach ($this->attributeIterator as $typescriptAttribute) {
            yield $this->writer->write(
                $typescriptAttribute,
                $typescriptGenerator->generate($typescriptAttribute),
            );
        }
    }
}
