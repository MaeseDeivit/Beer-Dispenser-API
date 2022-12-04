<?php

declare(strict_types=1);

namespace App\Health\Domain\Repository\Exceptions;

class DatabaseNotHealthyRepositoryException extends \Exception implements HealthRepositoryException
{
}
