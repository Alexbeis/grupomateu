<?php

namespace Mateu\Tests\UseCases;

use Mateu\Backend\Explotation\Application\GetAll\GetAllExplotationsUseCase;
use Mateu\Backend\Explotation\Domain\Entity\Explotation;
use Mateu\Infraestructure\Repository\ExplotationRepository;
use PHPUnit\Framework\TestCase;

class GetAllExplotationsUseCaseTest extends TestCase
{
    /**
     * @var GetAllExplotationsUseCase
     */
    private $getAllExplotationsUseCase;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $explotationRepositoryMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $explotationMock;

    protected function setUp()
    {
        $this->explotationMock = $this->createMock(Explotation::class);
        $this->explotationRepositoryMock = $this->createMock(ExplotationRepository::class);
        $this->getAllExplotationsUseCase = new GetAllExplotationsUseCase($this->explotationRepositoryMock);
    }

    protected function tearDown()
    {
        $this->explotationRepositoryMock = null;
        $this->getAllExplotationsUseCase = null;
    }

    protected function getArrayExplotationMocks()
    {
        $result = [];

        for ($i = 0; $i < 10; $i++) {
          $result[] = $this->explotationMock;
        }

        return $result;
    }

    /**
     * @test
     */
    public function shouldGetAllExplotations()
    {
        $this->explotationRepositoryMock
            ->expects($this->once())
            ->method('findAll')
            ->will(
                $this->returnValue(
                    $this->getArrayExplotationMocks()
                )
            );
        $explotations = $this->getAllExplotationsUseCase->execute();

        $this->assertEquals(10, count($explotations));


    }
}