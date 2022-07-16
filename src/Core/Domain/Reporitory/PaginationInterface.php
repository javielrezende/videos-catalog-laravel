<?php

namespace Core\Domain\Repository;

use stdClass;

interface PaginationInterface {
    /**
     * @return stdClass[]
     */
    public function items(): array;
    public function total(): int;
    public function currentPage(): int;
    public function firstPage(): int;
    public function lastPage(): int;
    public function perPage(): int;
    public function from(): int;
    public function to(): int;
}