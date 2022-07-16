<?php

namespace Core\UseCase\Dto\Category;

class CategoryDeleteOutputDto {
    public function __construct(
        public bool $success
    )
    {
    }
}