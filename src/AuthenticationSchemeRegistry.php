<?php

/**
 * Aphiria
 *
 * @link      https://www.aphiria.com
 * @copyright Copyright (C) 2023 David Young
 * @license   https://github.com/aphiria/aphiria/blob/1.x/LICENSE.md
 */

declare(strict_types=1);

namespace Aphiria\Authentication;

use OutOfBoundsException;

/**
 * Defines the authentication scheme registry
 */
final class AuthenticationSchemeRegistry
{
    /** @var AuthenticationScheme<AuthenticationSchemeOptions>|null The default scheme if one is set, otherwise null */
    private ?AuthenticationScheme $defaultScheme = null;
    /** @var array<string, AuthenticationScheme<AuthenticationSchemeOptions>> The mapping of authentication scheme names to schemes */
    private array $schemesByName = [];

    /**
     * Gets the default authentication scheme
     *
     * @template T of AuthenticationSchemeOptions
     * @return AuthenticationScheme<T>|null The default authentication scheme if one is set, otherwise null
     * @note If only a single scheme is registered, it'll be returned as the default
     * @psalm-suppress InvalidReturnStatement Psalm does not handle collections of different generics
     * @psalm-suppress InvalidReturnType Ditto
     */
    public function getDefaultScheme(): ?AuthenticationScheme
    {
        if ($this->defaultScheme !== null) {
            return $this->defaultScheme;
        }

        return \count($this->schemesByName) === 1 ? \array_values($this->schemesByName)[0] : null;
    }

    /**
     * Gets an authentication scheme by name
     *
     * @template T of AuthenticationSchemeOptions
     * @param string $schemeName The name of the authentication scheme to get
     * @return AuthenticationScheme<T> The authentication scheme with the input name
     * @throws OutOfBoundsException Thrown if no scheme with the input name was found
     * @psalm-suppress InvalidReturnStatement Psalm does not handle collections of different generics
     * @psalm-suppress InvalidReturnType Ditto
     */
    public function getScheme(string $schemeName): AuthenticationScheme
    {
        return $this->schemesByName[$schemeName] ?? throw new OutOfBoundsException("No authentication scheme with name \"$schemeName\" found");
    }

    /**
     * Registers an authentication scheme
     *
     * @template T of AuthenticationSchemeOptions
     * @param AuthenticationScheme<T> $scheme The scheme to register
     * @param bool $isDefault Whether or not this should be the default scheme
     */
    public function registerScheme(AuthenticationScheme $scheme, bool $isDefault = false): void
    {
        $this->schemesByName[$scheme->name] = $scheme;

        if ($isDefault) {
            $this->defaultScheme = $scheme;
        }
    }
}
