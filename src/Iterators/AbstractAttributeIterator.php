<?php

declare(strict_types=1);

namespace Returnless\InertiaTypescriptGenerator\Iterators;

use Illuminate\Support\Arr;
use IteratorAggregate;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use Returnless\InertiaTypescriptGenerator\Attributes\Typescript;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Traversable;

/**
 * @implements \IteratorAggregate<string, class-string>
 */
abstract class AbstractAttributeIterator implements IteratorAggregate
{
    /**
     * @return array<string, class-string>
     */
    abstract protected function getIterable(): array;

    /**
     * @return \Illuminate\Support\Collection<string, class-string>
     *
     * @throws \JsonException
     */
    public function getIterator(): Traversable
    {
        /** @var \Illuminate\Support\Collection<string, class-string> $autoloadContents */
        $autoloadContents = collect($this->getIterable())
            ->flatMap(static function (string $path, string $namespace) {
                /** @var list<\Symfony\Component\Finder\SplFileInfo> $files */
                $files = (new Finder)->in($path)
                    ->name('*.php')
                    ->files();

                return collect($files)
                    ->map(function (SplFileInfo $file) use ($namespace): string {
                        return $namespace . str_replace(
                            ['/', '.php'],
                            ['\\', ''],
                            $file->getRelativePathname(),
                        );
                    })
                    ->map(function (string $className) {
                        try {
                            /** @var class-string $className */
                            $reflectionClass = new ReflectionClass($className);

                            return Arr::first($reflectionClass->getAttributes(Typescript::class));
                        } catch (ReflectionException $e) {
                            return null;
                        }
                    })
                    ->filter() // Filter out all the classes that don't have the Typescript attribute.
                    ->map(fn (ReflectionAttribute $attribute) => $attribute->newInstance()->viewModel);
            });

        return $autoloadContents;
    }
}
