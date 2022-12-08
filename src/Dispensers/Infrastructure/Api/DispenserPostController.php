<?php

declare(strict_types=1);

namespace App\Dispensers\Infrastructure\Api;

use Ramsey\Uuid\Uuid;
use App\Shared\Domain\Bus\Command\CommandBus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Dispensers\Application\Create\CreateDispenserCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class DispenserPostController extends AbstractController
{
    public function __construct(
        private readonly CommandBus $commandBus,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $dispenserId = Uuid::uuid4()->toString();
        $flowVolume = (float) $request->request->get('flowVolume');

        $this->commandBus->dispatch(
            new CreateDispenserCommand(
                $dispenserId,
                $flowVolume
            )
        );

        return new Response();
    }

    protected function exceptions(): array
    {
        return [];
    }
}
