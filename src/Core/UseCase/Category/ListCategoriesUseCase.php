<?php

namespace Core\UseCase\Category;

use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Dto\Category\{
    ListCategoriesInputDto,
    ListCategoriesOutputDto
};

class ListCategoriesUseCase {
    protected $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;    
    }

    public function execute(ListCategoriesInputDto $input): ListCategoriesOutputDto
    {
        $categories = $this->repository->paginate(
            filter: $input->filter,
            order: $input->order,
            page: $input->page,
            totalPerPage: $input->totalPage,
        );

        return new ListCategoriesOutputDto(
            items: $categories->items(),
            // items: array_map(function ($data) {
            //     return [
            //         'id' => $data->id,
            //         'name' => $data->name,
            //         'description' => $data->description,
            //         'is_active' => (bool) $data->is_active,
            //         'created_at' => (string) $data->created_at,
            //     ]
            // }, $categories->items()),
            total: $categories->total(),
            currentPage: $categories->currentPage(),
            firstPage: $categories->firstPage(),
            lastPage: $categories->lastPage(),
            perPage: $categories->perPage(),
            from: $categories->from(),
            to: $categories->to(),
        );
    }
}