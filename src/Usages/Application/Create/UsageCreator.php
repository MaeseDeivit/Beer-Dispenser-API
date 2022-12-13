<?php

declare(strict_types=1);

namespace App\Usages\Application\Create;

use App\Usages\Domain\Model\Usage;
use App\Shared\Domain\Uuid\UsageId;
use App\Shared\Domain\Uuid\DispenserId;
use App\Shared\Domain\Bus\Event\EventBus;
use App\Usages\Domain\Exceptions\UsageAlreadyExistsException;
use App\Usages\Domain\Repository\UsageRepositoryInterface;
use DateTime;

final class UsageCreator
{

    public function __construct(private readonly UsageRepositoryInterface $repository, private readonly EventBus $bus)
    {
    }

    public function __invoke(
        UsageId $id,
        DispenserId $dispenserId,
        DateTime $openedAt
    ) {
        if (!is_null($this->repository->search($id))) {
            throw new UsageAlreadyExistsException($id->value());
        }

        $usage = Usage::create($id, $dispenserId, $openedAt);

        $this->repository->save($usage);
        $this->bus->publish(...$usage->pullDomainEvents());
    }
}
