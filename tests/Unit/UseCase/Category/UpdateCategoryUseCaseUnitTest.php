<?php

namespace Unit\Domain\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Category\UpdateCategoryUseCase;
use Core\UseCase\Dto\Category\CategoryUpdateInputDto;
use Core\UseCase\Dto\Category\CategoryUpdateOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class UpdateCategoryUseCaseUnitTest extends TestCase {
    private $mockEntity;
    private $mockRepository;
    private $mockInputDto;
    private $spy;
    
    public function testRenameCategory()
    {
        $id = Uuid::uuid4()->toString();
        $categoryName = 'Category 1';

        $this->mockEntity = Mockery::mock(Category::class, [
            $id,
            $categoryName
        ]);

        $this->mockEntity->shouldReceive('update');
        $this->mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $this->mockRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepository->shouldReceive('findById')->andReturn($this->mockEntity);
        $this->mockRepository->shouldReceive('update')->andReturn($this->mockEntity);

        $this->mockInputDto = Mockery::mock(CategoryUpdateInputDto::class, [
            $id, $categoryName . ' updated'
        ]);

        $useCase = new UpdateCategoryUseCase($this->mockRepository);
        $response = $useCase->execute($this->mockInputDto);

        $this->assertInstanceOf(CategoryUpdateOutputDto::class, $response);

        // Spies
        $this->spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('findById')->andReturn($this->mockEntity);
        $this->spy->shouldReceive('update')->andReturn($this->mockEntity);
        $useCase = new UpdateCategoryUseCase($this->spy);
        $useCase->execute($this->mockInputDto);
        $this->spy->shouldHaveReceived('findById');
        $this->spy->shouldHaveReceived('update');

        Mockery::close();
    }
}