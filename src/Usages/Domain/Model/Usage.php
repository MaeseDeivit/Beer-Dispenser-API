<?php

declare(strict_types=1);

namespace App\Usages\Domain\Model;

use App\Shared\Domain\Uuid\UsageId;
use App\Shared\Domain\Uuid\DispenserId;
use App\Usages\Domain\Model\ValueObject\UsageClosedAt;
use App\Usages\Domain\Model\ValueObject\UsageOpenedAt;
use App\Usages\Domain\Model\ValueObject\UsageTotalSpent;

class Usage
{
    private $id;
    private $dispenserId;
    private $totalSpent;
    private $openedAt;
    private $closedAt;

    public function __construct(
        string $id,
        string $dispenserId,
        float  $totalSpent,
        string $openedAt,
        string $closedAt = null
    ) {
        $this->id               = new UsageId($id);
        $this->dispenserId      = new DispenserId($dispenserId);
        $this->totalSpent       = new UsageTotalSpent($totalSpent);
        $this->openedAt         = new UsageOpenedAt($openedAt);
        $this->closedAt         = !is_null($closedAt) ? new UsageClosedAt($closedAt) : null;
    }
    public static function create(
        string $id,
        string $dispenserId,
        float  $totalSpent,
        string $openedAt = 'now'
    ): self {
        $usage = new self($id, $dispenserId, $totalSpent, $openedAt);
        // $usage->record(new UsageCreatedDomainEvent($id, $dispenserId, $totalSpent, $openedAt));

        return $usage;
    }

    public function id(): UsageId
    {
        return $this->id;
    }
    public function dispenserId(): DispenserId
    {
        return $this->dispenserId;
    }
    public function totalSpent(): UsageTotalSpent
    {
        return $this->totalSpent;
    }
    public function openedAt(): UsageOpenedAt
    {
        return $this->openedAt;
    }
    public function closedAt(): ?UsageClosedAt
    {
        return $this->closedAt;
    }
    public function values(): array
    {
        return [
            "id"          => $this->id->value(),
            "dispenserId" => $this->dispenserId->value(),
            "totalSpent"  => $this->totalSpent->value(),
            "openedAt"    => $this->openedAt->value(),
            "closedAt"    => !is_null($this->closedAt) ? $this->closedAt->__toString() : null
        ];
    }
}
