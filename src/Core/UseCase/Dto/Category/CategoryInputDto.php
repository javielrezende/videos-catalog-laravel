<?php

namespace Core\UseCase\Dto\Category;

class CategoryInputDto {
    public function __construct(
        public string $id = ''
    )
    {
    }
}