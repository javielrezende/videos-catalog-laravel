<?php

namespace Tests\Unit\Domain\Validation;

use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Validation\DomainValidation;
use PHPUnit\Framework\TestCase;
use Throwable;

class DomainValidationUnitTest extends TestCase {
    public function testNotNull()
    {
        try {
            $value = '';

            DomainValidation::notNull($value);

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }

    public function testNotNullWithCustomMessage()
    {
        try {
            $value = '';
            $customMessage = 'Custom message error';

            DomainValidation::notNull($value, $customMessage);

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th, $customMessage);
        }
    }

    public function testMaximumValueLength()
    {
        try {
            $value = 'Test';
            $customMessage = 'Custom message error';

            DomainValidation::maximumLength($value, 3, $customMessage);

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }

    public function testMinimumValueLength()
    {
        try {
            $value = 'Test';
            $customMessage = 'Custom message error';

            DomainValidation::minimumLength($value, 5, $customMessage);

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }

    public function testCanBeNullButWithMaximumCaractersNumber()
    {
        try {
            $value = 'Test';
            $customMessage = 'Custom message error';

            DomainValidation::nullWithMaximumLength($value, 3, $customMessage);

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }
}