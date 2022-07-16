<?php

namespace Unit\Domain\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Category\DeleteCategoryUseCase;
use Core\UseCase\Category\UpdateCategoryUseCase;
use Core\UseCase\Dto\Category\CategoryDeleteOutputDto;
use Core\UseCase\Dto\Category\CategoryInputDto;
use Core\UseCase\Dto\Category\CategoryUpdateInputDto;
use Core\UseCase\Dto\Category\CategoryUpdateOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class DeleteCategoryUseCaseUnitTest extends TestCase {
    private $mockRepository;
    private $mockInputDto;
    private $spy;
    
    public function testDeleteCategoryAndReturnTrue()
    {
        $id = Uuid::uuid4()->toString();

        $this->mockRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepository->shouldReceive('delete')->andReturn(true);

        $this->mockInputDto = Mockery::mock(CategoryInputDto::class, [
            $id
        ]);

        $useCase = new DeleteCategoryUseCase($this->mockRepository);
        $response = $useCase->execute($this->mockInputDto);

        $this->assertInstanceOf(CategoryDeleteOutputDto::class, $response);
        $this->assertTrue($response->success);

        // Spies
        $this->spy = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('delete')->andReturn(true);
        $useCase = new DeleteCategoryUseCase($this->spy);
        $useCase->execute($this->mockInputDto);
        $this->spy->shouldHaveReceived('delete');
    }

    public function testDeleteCategoryAndReturnFalse()
    {
        $id = Uuid::uuid4()->toString();

        $this->mockRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepository->shouldReceive('delete')->andReturn(false);

        $this->mockInputDto = Mockery::mock(CategoryInputDto::class, [
            $id
        ]);

        $useCase = new DeleteCategoryUseCase($this->mockRepository);
        $response = $useCase->execute($this->mockInputDto);

        $this->assertInstanceOf(CategoryDeleteOutputDto::class, $response);
        $this->assertFalse($response->success);

        // Spies
        $this->spy = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('delete')->andReturn(true);
        $useCase = new DeleteCategoryUseCase($this->spy);
        $useCase->execute($this->mockInputDto);
        $this->spy->shouldHaveReceived('delete');
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}