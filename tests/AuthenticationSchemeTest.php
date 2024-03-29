<?php

/**
 * Aphiria
 *
 * @link      https://www.aphiria.com
 * @copyright Copyright (C) 2023 David Young
 * @license   https://github.com/aphiria/aphiria/blob/1.x/LICENSE.md
 */

declare(strict_types=1);

namespace Aphiria\Authentication\Tests;

use Aphiria\Authentication\AuthenticationScheme;
use Aphiria\Authentication\AuthenticationSchemeOptions;
use Aphiria\Authentication\Schemes\IAuthenticationSchemeHandler;
use PHPUnit\Framework\TestCase;

class AuthenticationSchemeTest extends TestCase
{
    public function testConstructorSetsAllProperties(): void
    {
        /** @var IAuthenticationSchemeHandler<AuthenticationSchemeOptions> $expectedHandler */
        $expectedHandler = $this->createMock(IAuthenticationSchemeHandler::class);
        $expectedOptions = new AuthenticationSchemeOptions();
        $scheme = new AuthenticationScheme('foo', $expectedHandler::class, $expectedOptions);
        $this->assertSame('foo', $scheme->name);
        $this->assertSame($expectedHandler::class, $scheme->handlerClassName);
        $this->assertSame($expectedOptions, $scheme->options);
    }
}
