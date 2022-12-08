<?php

declare(strict_types=1);

namespace App\Dispensers\Infrastructure\Api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Uuid;
use App\Shared\Infrastructure\Symfony\ApiController;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Collection;
use App\Dispensers\Application\Create\CreateDispenserCommand;

final class DispenserPostController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        $validationErrors = $this->validateRequest($request);

        if (!is_null($validationErrors)) return $this->errorResponse(Response::HTTP_BAD_REQUEST, 9001, $validationErrors);;

        $dispenserId = (string) $request->request->get('dispenserId');
        $flowVolume  = (float) $request->request->get('flowVolume');

        $this->dispatch(
            new CreateDispenserCommand(
                $dispenserId,
                $flowVolume
            )
        );
        return $this->successResponse(Response::HTTP_CREATED);
    }

    private function validateRequest(Request $request): ?array
    {
        $constraint = new Collection(
            [
                'dispenserId'    => [new NotBlank(), new Uuid()],
                'flowVolume'     => [new NotBlank(), new Positive(), new Type(["integer", "float"])]
            ]
        );

        $input = $request->request->all();

        return $this->requestValidation($input, $constraint);
    }
}
