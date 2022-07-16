<?php

namespace Unit\Domain\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Category\ListCategoryUseCase;
use Core\UseCase\Dto\Category\CategoryInputDto;
use Core\UseCase\Dto\Category\CategoryOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class ListCategoryUseCaseUnitTest extends TestCase {
    private $mockEntity;
    private $mockRepository;
    private $mockInputDto;
    
    public function testGetById()
    {
        $id = Uuid::uuid4()->toString();
        $categoryName = 'Category 1';

        $this->mockEntity = Mockery::mock(Category::class, [
            $id,
            $categoryName
        ]);
        $this->mockEntity->shouldReceive('id')->andReturn($id);
        $this->mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $this->mockRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepository->shouldReceive('findById')
            ->with($id)
            ->andReturn($this->mockEntity);

        $this->mockInputDto = Mockery::mock(CategoryInputDto::class, [
            $id
        ]);

        $useCase = new ListCategoryUseCase($this->mockRepository);
        $response = $useCase->execute($this->mockInputDto);

        $this->assertInstanceOf(CategoryOutputDto::class, $response);
        $this->assertEquals($categoryName, $response->name);
        $this->assertEquals($id, $response->id);

        // Spies
        $this->spy = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('findById')
            ->with($id)
            ->andReturn($this->mockEntity);
        $useCase = new ListCategoryUseCase($this->spy);
        $useCase->execute($this->mockInputDto);
        $this->spy->shouldReceive('findById');

        Mockery::close();
    }
}