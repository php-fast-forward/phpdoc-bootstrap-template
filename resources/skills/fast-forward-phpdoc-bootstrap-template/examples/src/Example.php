<?php

declare(strict_types=1);

namespace Example\Documentation;

/** Provides a greeting for the documentation example. */
final class Example
{
    /** Return a greeting addressed to the reader. */
    public function greet(string $name): string
    {
        return 'Hello, ' . $name . '!';
    }
}
