<?php

declare(strict_types=1);

namespace Returnless\InertiaTypescriptGenerator;

use Generator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use ReflectionAttribute;
use ReflectionClass;
use Returnless\InertiaTypescriptGenerator\Attributes\TypescriptNamespace;
use Returnless\InertiaTypescriptGenerator\Iterators\AbstractAttributeIterator;
use Returnless\TypescriptGenerator\TypescriptGenerator;

final readonly class InertiaTypescriptGenerator
{
    public function __construct(
        private AbstractAttributeIterator $attributeIterator,
        private string $outputPath,
    ) {}

    /**
     * @return \Generator<class-string>
     *
     * @throws \ReflectionException
     */
    public function generate(): Generator
    {
        $typescriptGenerator = new TypescriptGenerator;

        foreach ($this->attributeIterator as $typescriptAttribute) {
            $this->writeStackToFile($typescriptAttribute, $typescriptGenerator->generate($typescriptAttribute));

            yield $typescriptAttribute;
        }
    }

    /**
     * @param  class-string  $typescriptAttribute
     *
     * @throws \ReflectionException
     */
    private function getPath(string $typescriptAttribute): string
    {
        $reflectionClass = new ReflectionClass($typescriptAttribute);

        $path = config('inertia-typescript-generator.page_path') . '/' . $reflectionClass->getProperty('viewPath')->getDefaultValue() . '/types.ts';

        /** @var \ReflectionAttribute<\Returnless\InertiaTypescriptGenerator\Attributes\TypescriptNamespace>|null $reflectionAttribute */
        $reflectionAttribute = Arr::first(
            array: $reflectionClass->getAttributes(TypescriptNamespace::class),
            default: $reflectionClass->getParentClass() instanceof ReflectionClass
                ? Arr::first($reflectionClass->getParentClass()->getAttributes(TypescriptNamespace::class))
                : null,
        );

        if ($reflectionAttribute instanceof ReflectionAttribute) {
            $reflectionAttributeInstance = $reflectionAttribute->newInstance();

            return $reflectionAttributeInstance->namespace . '/' . $path;
        }

        return $path;
    }

    /**
     * @param  class-string  $typescriptAttribute
     *
     * @throws \ReflectionException
     */
    private function writeStackToFile(string $typescriptAttribute, string $generatedClassTypes): void
    {
        $path = $this->outputPath . '/' . $this->getPath($typescriptAttribute);

        File::ensureDirectoryExists(dirname($path));
        File::put($path, $generatedClassTypes);
    }
}
