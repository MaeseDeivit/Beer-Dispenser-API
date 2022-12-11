<?php

declare(strict_types=1);

namespace App\Usages\Domain\Model;

use App\Dispensers\Domain\Model\DispenserFlowVolume;
use DateTime;
use App\Shared\Domain\Uuid\UsageId;
use App\Shared\Domain\Uuid\DispenserId;
use App\Usages\Domain\Model\UsageClosedAt;
use App\Usages\Domain\Model\UsageOpenedAt;
use App\Usages\Domain\Model\UsageTotalSpent;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Usages\Domain\Events\UsageOpenedDomainEvent;

class Usage extends AggregateRoot
{
    private DispenserFlowVolume $flowVolume;

    public function __construct(
        private readonly UsageId $id,
        private readonly DispenserId $dispenserId,
        private UsageTotalSpent $totalSpent,
        private readonly DateTime $openedAt,
        private ?DateTime $closedAt = null
    ) {
    }
    public static function create(
        UsageId $id,
        DispenserId $dispenserId
    ): self {
        $openedAt = new DateTime('now');
        $usage = new self($id, $dispenserId, new UsageTotalSpent(null), $openedAt, null);
        $usage->record(new UsageOpenedDomainEvent($id->value(), $dispenserId->value(), $openedAt->format('Y-m-d H:i:s')));

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
    public function setTotalSpent(UsageTotalSpent $totalSpent): void
    {
        $this->totalSpent = $totalSpent;
    }
    public function totalSpent(): ?UsageTotalSpent
    {
        return $this->totalSpent;
    }
    public function setFlowVolume(DispenserFlowVolume $flowVolume): void
    {
        $this->flowVolume = $flowVolume;
    }
    public function flowVolume(): ?DispenserFlowVolume
    {
        return $this->flowVolume;
    }
    public function openedAt(): DateTime
    {
        return $this->openedAt;
    }
    public function closedAt(): ?DateTime
    {
        return $this->closedAt;
    }
    public function values(): array
    {
        return [
            "id"          => $this->id->value(),
            "dispenserId" => $this->dispenserId->value(),
            "totalSpent"  => !is_null($this->totalSpent) ? $this->totalSpent->value() : null,
            "openedAt"    => $this->openedAt->format('Y-m-d H:i:s'),
            "closedAt"    => !is_null($this->closedAt) ? $this->closedAt->format('Y-m-d H:i:s') : null
        ];
    }
}
