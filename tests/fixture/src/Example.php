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
     * ```php
     * $example = new Example();
     * echo $example->greet('Dash');
     * ```
     *
     * @since 1.0.0
     * @param string $name Reader name.
     * @return string A personalized greeting.
     */
    #[ExampleAttribute]
    public function greet(string $name): string
    {
        return 'Hello, ' . $name;
    }
    /** @since 1.1.0 */
    #[ExampleAttribute]
    public function farewell(): string
    {
        return 'Goodbye';
    }
}
