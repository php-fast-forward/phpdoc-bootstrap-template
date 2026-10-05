<?php

declare(strict_types=1);

namespace FastForward\Documentation;

/**
 * Demonstrates generated API navigation and readable source examples.
 */
final class Example
{
    /**
     * Return a greeting for the documentation reader.
     *
     * @param string $name Reader name.
     * @return string A personalized greeting.
     */
    public function greet(string $name): string
    {
        return 'Hello, ' . $name;
    }
}
