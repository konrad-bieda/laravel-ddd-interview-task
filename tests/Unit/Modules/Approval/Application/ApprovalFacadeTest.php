<?php

namespace Tests\Unit\Modules\Approval\Application;

use App\Domain\Shared\Enums\StatusEnum;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Approval\Application\ApprovalFacade;
use Illuminate\Contracts\Events\Dispatcher;
use LogicException;
use Mockery\MockInterface;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class ApprovalFacadeTest extends TestCase
{
    public function testApproveWithInvalidStatusShouldThrowException(): void
    {
        $dto = new ApprovalDto(
            Uuid::fromString($this->faker->uuid()),
            $this->faker->randomElement([StatusEnum::APPROVED, StatusEnum::REJECTED]),
            $this->faker->word(),
        );

        /** @var ApprovalFacade $facade */
        $facade =  app(ApprovalFacade::class);

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('approval status is already assigned');
        $facade->approve($dto);
    }

    public function testApproveWithValidStatusShouldReturnTrue(): void
    {
        $dto = new ApprovalDto(
            Uuid::fromString($this->faker->uuid()),
            StatusEnum::DRAFT,
            $this->faker->word(),
        );

        $dispatcher = $this->mock(Dispatcher::class, function (MockInterface $mock) {
            $mock->shouldReceive('dispatch')->once();
        });

        /** @var ApprovalFacadeInterface $facade */
        $facade = app(ApprovalFacadeInterface::class, [
            'dispatcher' => $dispatcher,
        ]);

        $this->assertTrue($facade->approve($dto));
    }

    public function testRejectWithInvalidStatusShouldThrowException(): void
    {
        $dto = new ApprovalDto(
            Uuid::fromString($this->faker->uuid()),
            $this->faker->randomElement([StatusEnum::APPROVED, StatusEnum::REJECTED]),
            $this->faker->word(),
        );

        /** @var ApprovalFacade $facade */
        $facade =  app(ApprovalFacade::class);

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('approval status is already assigned');
        $facade->reject($dto);
    }

    public function testRejectWithValidStatusShouldReturnTrue(): void
    {
        $dto = new ApprovalDto(
            Uuid::fromString($this->faker->uuid()),
            StatusEnum::DRAFT,
            $this->faker->word(),
        );

        $dispatcher = $this->mock(Dispatcher::class, function (MockInterface $mock) {
            $mock->shouldReceive('dispatch')->once();
        });

        /** @var ApprovalFacadeInterface $facade */
        $facade = app(ApprovalFacadeInterface::class, [
            'dispatcher' => $dispatcher,
        ]);

        $this->assertTrue($facade->reject($dto));
    }
}
