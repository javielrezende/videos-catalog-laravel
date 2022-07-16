<?php

namespace Core\UseCase\Category;

use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Dto\Category\{
    CategoryDeleteOutputDto,
    CategoryInputDto,
};

class DeleteCategoryUseCase {
    protected $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;    
    }

    public function execute(CategoryInputDto $input): CategoryDeleteOutputDto
    {
        $response = $this->repository->delete($input->id);

        return new CategoryDeleteOutputDto(
            success: $response
        );
    }
}