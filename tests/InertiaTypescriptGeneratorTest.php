<?php

declare(strict_types=1);

namespace Returnless\InertiaTypescriptGenerator\Tests;

use PHPUnit\Framework\Attributes\Test;
use Returnless\InertiaTypescriptGenerator\InertiaTypescriptGenerator;
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

        foreach ($inertiaTypescriptGenerator->generate() as $item) {
            self::assertSame('export type TestStubViewModel = {name: string; isBar: boolean;};', $item);
        }
    }
}
