<?php

declare(strict_types=1);

namespace App\Dispensers\Infrastructure\Api;

use Throwable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Shared\Infrastructure\Symfony\ApiController;
use App\Dispensers\Application\Create\CreateDispenserCommand;
use App\Dispensers\Domain\Exceptions\DispenserAlreadyExistsException;

final class DispenserPostController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        $dispenserId = (string) $request->request->get('dispenserId');
        $flowVolume = (float) $request->request->get('flowVolume');

        $this->dispatch(
            new CreateDispenserCommand(
                $dispenserId,
                $flowVolume
            )
        );
        return $this->successResponse(Response::HTTP_CREATED);
    }
}
