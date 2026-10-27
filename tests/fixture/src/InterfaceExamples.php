<?php

declare(strict_types=1);

namespace FastForward\Documentation;

/** A documented local interface with a generated API page. */
interface LocalContract
{
}

/** References both a documented interface and an unresolved external interface. */
final class InterfaceExample implements LocalContract, \External\Package\MissingContract
{
}

/** Provides the control case without implemented interfaces. */
final class NoInterfaceExample
{
}
