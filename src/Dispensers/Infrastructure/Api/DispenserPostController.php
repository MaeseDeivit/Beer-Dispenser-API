<?php

declare(strict_types=1);

namespace App\Dispensers\Infrastructure\Api;

use App\Shared\Domain\Bus\Command\CommandBus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Dispensers\Application\Create\CreateDispenserCommand;
use App\Shared\Infrastructure\Symfony\ApiController;

final class DispenserPostController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        try {
            $dispenserId = (string) $request->request->get('dispenserId');
            $flowVolume = (float) $request->request->get('flowVolume');

            $this->dispatch(
                new CreateDispenserCommand(
                    $dispenserId,
                    $flowVolume
                )
            );

            return new Response();
        } catch (\Throwable $th) {
            return new Response($th->getMessage(), 401);
        }
    }

    protected function exceptions(): array
    {
        return [];
    }
}
