<?php

declare(strict_types=1);

namespace App\Dispensers\Infrastructure\Api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Dispensers\Domain\Model\DispenserStatus;
use Symfony\Component\Validator\Constraints\Choice;
use App\Shared\Infrastructure\Symfony\ApiController;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Collection;
use App\Dispensers\Application\Open\OpenDispenserCommand;

final class DispenserChangeStatusPutController extends ApiController
{
    public function __invoke(string $id, Request $request): Response
    {
        $validationErrors = $this->validateRequest($request);

        if (!is_null($validationErrors)) return $this->errorResponse(Response::HTTP_BAD_REQUEST, 9001, $validationErrors);;

        $status = (string) $request->request->get('status');


        if ($status === DispenserStatus::OPEN) {
            $this->dispatch(
                new OpenDispenserCommand(
                    $id
                )
            );
        }

        return $this->successResponse(Response::HTTP_CREATED);
    }

    private function validateRequest(Request $request): ?array
    {
        $constraint = new Collection(
            [
                'status'    => [new NotBlank(), new Choice([DispenserStatus::OPEN, DispenserStatus::CLOSE])]
            ]
        );

        $input = $request->request->all();

        return $this->requestValidation($input, $constraint);
    }
}
