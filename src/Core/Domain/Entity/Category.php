<?php

namespace Core\Domain\Entity;

use Core\Domain\Entity\Traits\MagicMethodsTrait;
use Core\Domain\Validation\DomainValidation;
use Core\Domain\ValueObject\Uuid;
use DateTime;

class Category {
    use MagicMethodsTrait;

    public function __construct(
        protected Uuid|string $id = '',
        protected string $name = '',
        protected string $description = '',
        protected bool $isActive = true,
        protected DateTime|string $createdAt = ''
    ) {
        // Se for string (e existir) somente passa para o tipo Uuid
        // senão cria o novo
        $this->id = $this->id ? new Uuid($this->id) : UUid::random();
        $this->createdAt = $this->createdAt ? new DateTime($this->createdAt) : new DateTime();
        $this->validate();
    }

    public function activate(): void
    {
        $this->isActive = true;
    }

    public function deactivate(): void
    {
        $this->isActive = false;
    }

    public function update(string $name = null, string $description = null): void
    {
        $this->validate();
        $this->name = $name ?? $this->name;
        $this->description = $description ?? $this->description;
    }

    private function validate()
    {
        DomainValidation::notNull($this->name);
        DomainValidation::maximumLength($this->name);
        DomainValidation::minimumLength($this->name);
        DomainValidation::nullWithMaximumLength($this->description);
    }
}