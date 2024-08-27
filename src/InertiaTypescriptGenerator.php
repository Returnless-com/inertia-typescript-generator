<?php

declare(strict_types=1);

namespace Returnless\InertiaTypescriptGenerator;

use Generator;
use Returnless\InertiaTypescriptGenerator\Iterators\AbstractAttributeIterator;
use Returnless\InertiaTypescriptGenerator\Writers\WriterInterface;
use Returnless\TypescriptGenerator\TypescriptGenerator;
use Symfony\Component\Process\Process;

final readonly class InertiaTypescriptGenerator
{
    public function __construct(
        private AbstractAttributeIterator $attributeIterator,
        private WriterInterface $writer,
    ) {}

    /**
     * @return \Generator<class-string, string>
     *
     * @throws \ReflectionException
     */
    public function generate(): Generator
    {
        $typescriptGenerator = new TypescriptGenerator;

        /** @var class-string $typescriptAttribute */
        foreach ($this->attributeIterator as $typescriptAttribute) {
            $output = $this->writer->write(
                $typescriptAttribute,
                $typescriptGenerator->generate($typescriptAttribute),
            );

            yield $typescriptAttribute => $output;
        }

        $this->afterGenerate();
    }

    private function afterGenerate(): void
    {
        /** @var array<string, list<string>> $afterGenerate */
        $afterGenerate = config('inertia-typescript-generator.after_generate') ?? [];

        foreach ($afterGenerate as $command => $arguments) {
            $this->runProcess($command, $arguments);
        }
    }

    /**
     * @param  list<string>  $arguments
     */
    private function runProcess(string $command, array $arguments): void
    {
        $filePattern = config('inertia-typescript-generator.output_path') . '/**/types.ts';

        array_unshift($arguments, $command);

        $process = new Process(['npx', '--yes', ...$arguments, $filePattern]);
        $process->run();
    }
}
