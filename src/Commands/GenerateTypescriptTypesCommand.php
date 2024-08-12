<?php

declare(strict_types=1);

namespace Returnless\InertiaTypescriptGenerator\Commands;

use Illuminate\Console\Command;
use Returnless\InertiaTypescriptGenerator\InertiaTypescriptGenerator;
use Returnless\InertiaTypescriptGenerator\Iterators\Psr4AttributeIterator;

final class GenerateTypescriptTypesCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'inertia-typescript:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Typescript types for your resources.';

    /**
     * @throws \ReflectionException
     */
    public function handle(): int
    {
        /** @var string $outputPath */
        $outputPath = config('inertia-typescript-generator.output_path');

        $typescriptGenerator = new InertiaTypescriptGenerator(
            new Psr4AttributeIterator,
            $outputPath,
        );

        foreach ($typescriptGenerator->generate() as $file) {
            $this->info("Generated: $file");
        }

        return self::SUCCESS;
    }
}
