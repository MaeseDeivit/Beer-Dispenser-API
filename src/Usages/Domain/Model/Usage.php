<?php

declare(strict_types=1);

namespace App\Usages\Domain\Model;

use DateTime;
use App\Shared\Domain\Uuid\UsageId;
use App\Shared\Domain\Uuid\DispenserId;
use App\Usages\Domain\Model\UsageTotalSpent;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Dispensers\Domain\Model\DispenserFlowVolume;
use App\Usages\Domain\Events\UsageOpenedDomainEvent;
use App\Usages\Domain\Events\UsageCompletedDomainEvent;
use App\Usages\Domain\Exceptions\UsageAlreadyClosedException;

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
        DispenserId $dispenserId,
        DateTime $openedAt
    ): self {
        $usage = new self($id, $dispenserId, new UsageTotalSpent(null), $openedAt, null);
        $usage->record(new UsageOpenedDomainEvent($id->value(), $dispenserId->value(), $openedAt->format('Y-m-d H:i:s')));

        return $usage;
    }
    public function completedUsage(DispenserFlowVolume $dispenserFlowVolume, DateTime $closedAt): void
    {
        $timeOpenSeconds = $closedAt->diff($this->openedAt())->s;
        $this->closedAt = $closedAt;

        $this->totalSpent = new UsageTotalSpent(($timeOpenSeconds * $dispenserFlowVolume->value()) * 12.25);

        $this->record(new UsageCompletedDomainEvent(
            $this->id->value(),
            $this->dispenserId->value(),
            $this->totalSpent->value(),
            $this->openedAt->format('Y-m-d H:i:s'),
            $this->closedAt->format('Y-m-d H:i:s')
        ));
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

    public function validateCompleteUsage(): void
    {
        if (!is_null($this->totalSpent->value()) || !is_null($this->closedAt)) throw new UsageAlreadyClosedException($this->id->value());
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
