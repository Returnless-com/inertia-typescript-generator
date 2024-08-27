<?php

declare(strict_types=1);

namespace Returnless\InertiaTypescriptGenerator\Commands;

use Illuminate\Console\Command;
use Returnless\InertiaTypescriptGenerator\InertiaTypescriptGenerator;
use Returnless\InertiaTypescriptGenerator\Iterators\Psr4AttributeIterator;
use Returnless\InertiaTypescriptGenerator\Writers\FileWriter;

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
        $typescriptGenerator = new InertiaTypescriptGenerator(
            new Psr4AttributeIterator,
            new FileWriter,
        );

        foreach ($typescriptGenerator->generate() as $attribute => $output) {
            $this->info("Generated typescript types for: $attribute");
        }

        return self::SUCCESS;
    }
}
