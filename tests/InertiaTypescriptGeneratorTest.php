<?php

declare(strict_types=1);

namespace Returnless\InertiaTypescriptGenerator\Tests;

use PHPUnit\Framework\Attributes\Test;
use Returnless\InertiaTypescriptGenerator\InertiaTypescriptGenerator;
use Returnless\InertiaTypescriptGenerator\Tests\Stubs\TestStubViewModel;
use Returnless\InertiaTypescriptGenerator\Writers\ConsoleWriter;

final class InertiaTypescriptGeneratorTest extends TestCase
{
    #[Test]
    public function it_can_generate_typescript_types(): void
    {
        $inertiaTypescriptGenerator = new InertiaTypescriptGenerator(
            new DummyAttributeIterator,
            new ConsoleWriter,
        );

        foreach ($inertiaTypescriptGenerator->generate() as $attribute => $output) {
            self::assertSame(TestStubViewModel::class, $attribute);
            self::assertSame('export type TestStubViewModel = {name: string; isBar: boolean;};', $output);
        }
    }
}
