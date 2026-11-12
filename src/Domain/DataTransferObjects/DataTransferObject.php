<?php

declare(strict_types=1);

namespace Lines\Support\Domain\DataTransferObjects;

use LogicException;
use ReflectionClass;

abstract readonly class DataTransferObject
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, mixed>
     */
    protected static function casts(): array
    {
        return [];
    }

    /**
     * Get a concrete instance of a DTO with values passed in through an array.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $constructor = (new ReflectionClass(static::class))->getConstructor();

        // A DTO is built from an array alone: a public constructor would open a second way in.
        if ($constructor->isPublic()) {
            throw new LogicException(static::class.' must declare its constructor protected or private.');
        }

        $parameters = $constructor->getParameters();
        $casts = static::casts();

        $arguments = [];
        foreach ($parameters as $p) {
            $k = $p->getName();
            $v = $data[$k] ?? null;

            $arguments[$k] = isset($casts[$k]) ? $casts[$k]($v, $data) : $v;
        }

        // Each subclass declares its own non-public constructor; the arguments come from its reflection.
        return new static(...$arguments); // @phpstan-ignore new.static
    }
}
