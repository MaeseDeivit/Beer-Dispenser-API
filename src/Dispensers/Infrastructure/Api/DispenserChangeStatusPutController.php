<?php

declare(strict_types=1);

namespace App\Dispensers\Infrastructure\Api;

use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Dispensers\Domain\Model\DispenserStatus;
use Symfony\Component\Validator\Constraints\Choice;
use App\Shared\Infrastructure\Symfony\ApiController;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Collection;
use App\Dispensers\Application\Open\OpenDispenserCommand;
use App\Dispensers\Application\Close\CloseDispenserCommand;
use App\Usages\Domain\Exceptions\UsageAlreadyExistsException;
use App\Dispensers\Domain\Exceptions\DispenserNotExistException;
use App\Dispensers\Domain\Exceptions\DispenserAlreadyClosedException;
use App\Dispensers\Domain\Exceptions\DispenserAlreadyOpenedException;

final class DispenserChangeStatusPutController extends ApiController
{
    public function __invoke(string $id, Request $request): Response
    {
        if (!Uuid::isValid($id)) {
            return $this->errorResponse(Response::HTTP_BAD_REQUEST, 9001, 'Not valid UUID format');
        }

        $validationErrors = $this->validateRequest($request);

        if (!is_null($validationErrors)) return $this->errorResponse(Response::HTTP_BAD_REQUEST, 9001, $validationErrors);;

        $status = (string) $request->request->get('status');


        ($status === DispenserStatus::OPEN) ?
            $this->dispatch(
                new OpenDispenserCommand(
                    $id
                )
            ) : $this->dispatch(
                new CloseDispenserCommand(
                    $id
                )
            );


        return $this->successResponse(Response::HTTP_ACCEPTED);
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

    protected function exceptions(): array
    {
        return [
            DispenserNotExistException::class       => Response::HTTP_NOT_FOUND,
            DispenserAlreadyOpenedException::class  => Response::HTTP_CONFLICT,
            DispenserAlreadyClosedException::class  => Response::HTTP_CONFLICT,
            UsageAlreadyExistsException::class      => Response::HTTP_CONFLICT,

        ];
    }
}
