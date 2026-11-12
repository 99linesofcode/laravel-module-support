<?php

declare(strict_types=1);

namespace Lines\Support\Core\SharedKernel\ValueObjects;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

/**
 * @implements CastsAttributes<UserId|null, UserId|string|null>
 */
final class AsUserId implements CastsAttributes
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?UserId
    {
        return $value === null ? null : new UserId((string) $value);
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        if ($value === null) {
            return null;
        }

        return (string) ($value instanceof UserId ? $value : new UserId((string) $value));
    }
}
