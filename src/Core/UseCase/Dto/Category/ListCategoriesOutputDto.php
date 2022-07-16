<?php

namespace Core\UseCase\Dto\Category;

class ListCategoriesOutputDto {
    public function __construct(
        public array $items,
        public int $total,
        public int $currentPage,
        public int $firstPage,
        public int $lastPage,
        public int $perPage,
        public int $from,
        public int $to
    )
    {
    }
}