<?php

declare(strict_types=1);

namespace Returnless\InertiaTypescriptGenerator\Writers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use ReflectionAttribute;
use ReflectionClass;
use Returnless\InertiaTypescriptGenerator\Attributes\TypescriptNamespace;

final class FileWriter implements WriterInterface
{
    /**
     * @param  class-string  $attribute
     *
     * @throws \ReflectionException
     */
    public function write(string $attribute, string $contents): string
    {
        $this->writeStackToFile($attribute, $contents);

        return $contents;
    }

    /**
     * @param  class-string  $typescriptAttribute
     *
     * @throws \ReflectionException
     */
    private function writeStackToFile(string $typescriptAttribute, string $generatedClassTypes): void
    {
        /** @var string $outputPath */
        $outputPath = config('inertia-typescript-generator.output_path');

        $path = config('inertia-typescript-generator.output_path') . '/' . $this->getPath($typescriptAttribute);

        File::ensureDirectoryExists(dirname($path));
        File::put($path, $generatedClassTypes);
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
}
