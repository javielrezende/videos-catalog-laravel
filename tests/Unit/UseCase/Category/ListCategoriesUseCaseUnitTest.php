<?php

namespace Unit\Domain\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\Domain\Repository\PaginationInterface;
use Core\UseCase\Category\ListCategoriesUseCase;
use Core\UseCase\Category\ListCategoryUseCase;
use Core\UseCase\Dto\Category\CategoryInputDto;
use Core\UseCase\Dto\Category\CategoryOutputDto;
use Core\UseCase\Dto\Category\ListCategoriesInputDto;
use Core\UseCase\Dto\Category\ListCategoriesOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class ListCategoriesUseCaseUnitTest extends TestCase {
    private $mockPagination;
    private $mockRepository;
    private $mockInputDto;
    private $spy;
    
    public function testListCategoriesEmpty()
    {
        $this->createMockPagination();

        $this->mockRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepository->shouldReceive('paginate')
            ->andReturn($this->mockPagination);

        $this->mockInputDto = Mockery::mock(ListCategoriesInputDto::class, [
            'filter', 'desc'
        ]);

        $useCase = new ListCategoriesUseCase($this->mockRepository);
        $response = $useCase->execute($this->mockInputDto);

        $this->assertCount(0, $response->items);
        $this->assertInstanceOf(ListCategoriesOutputDto::class, $response);

        /**
         * Spies
         */
        $this->spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('paginate')
            ->andReturn($this->mockPagination);
        $useCase = new ListCategoriesUseCase($this->spy);
        $useCase->execute($this->mockInputDto);
        $this->spy->shouldHaveReceived('paginate');
    }

    public function testListCategories()
    {
        $register = new stdClass();
        $register->id = 'id';
        $register->name = 'name';
        $register->description = 'description';
        $register->is_active = 'is_active';
        $register->updated_at = 'updated_at';
        $register->deleted_at = 'deleted_at';

        $this->createMockPagination([$register]);

        $this->mockRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepository->shouldReceive('paginate')
            ->andReturn($this->mockPagination);

        $this->mockInputDto = Mockery::mock(ListCategoriesInputDto::class, [
            'filter', 'desc'
        ]);

        $useCase = new ListCategoriesUseCase($this->mockRepository);
        $response = $useCase->execute($this->mockInputDto);

        $this->assertCount(1, $response->items);
        $this->assertInstanceOf(stdClass::class, $response->items[0]);
        $this->assertInstanceOf(ListCategoriesOutputDto::class, $response);
    }

    protected function createMockPagination(array $items = [])
    {
        $this->mockPagination = Mockery::mock(stdClass::class, PaginationInterface::class);
        $this->mockPagination->shouldReceive('items')->andReturn($items);
        $this->mockPagination->shouldReceive('total')->andReturn(0);
        $this->mockPagination->shouldReceive('currentPage')->andReturn(0);
        $this->mockPagination->shouldReceive('firstPage')->andReturn(0);
        $this->mockPagination->shouldReceive('lastPage')->andReturn(0);
        $this->mockPagination->shouldReceive('perPage')->andReturn(0);
        $this->mockPagination->shouldReceive('from')->andReturn(0);
        $this->mockPagination->shouldReceive('to')->andReturn(0);

        return $this->mockPagination;
    }
    
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}