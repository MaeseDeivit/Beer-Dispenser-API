<?php

declare(strict_types=1);

namespace App\Dispensers\Domain\Model;

use DateTime;
use App\Usages\Domain\Model\Usage;
use App\Shared\Domain\Uuid\UsageId;
use App\Shared\Domain\Uuid\DispenserId;
use App\Usages\Domain\Model\UsageTotalSpent;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Dispensers\Domain\Model\DispenserStatus;
use Doctrine\Common\Collections\ArrayCollection;
use App\Dispensers\Domain\Model\DispenserFlowVolume;
use App\Dispensers\Domain\Model\DispenserTotalAmount;
use App\Dispensers\Domain\Events\DispenserClosedDomainEvent;
use App\Dispensers\Domain\Events\DispenserOpenedDomainEvent;
use App\Dispensers\Domain\Events\DispenserCreatedDomainEvent;
use App\Dispensers\Domain\Exceptions\DispenserNotGotUsagesException;
use App\Dispensers\Domain\Exceptions\DispenserAlreadyClosedException;
use App\Dispensers\Domain\Exceptions\DispenserAlreadyOpenedException;
use App\Dispensers\Domain\Exceptions\DispenserNotGotIncompleteUsageException;
use App\Dispensers\Domain\Exceptions\DispenserHasManyIncompleteUsageException;

class Dispenser extends AggregateRoot
{
    private ?DispenserTotalAmount $totalAmount = null;

    public function __construct(
        private readonly DispenserId $id,
        private readonly DispenserFlowVolume $flowVolume,
        private DispenserStatus $status,
        private readonly DateTime $createdOn,
        private ?DateTime $updatedOn,
        private array $usages
    ) {
    }
    public static function create(
        DispenserId $id,
        DispenserFlowVolume $flowVolume
    ): self {
        $status = new DispenserStatus(DispenserStatus::CLOSE);
        $createdOn = new DateTime('now');

        $dispenser = new self($id, $flowVolume, $status, $createdOn, null, []);
        $dispenser->record(new DispenserCreatedDomainEvent($id->value(), $flowVolume->value(), $status->value(), $createdOn->format('Y-m-d H:i:s')));

        return $dispenser;
    }

    public function changeStatusOpen(DateTime $now): void
    {
        $this->status = new DispenserStatus(DispenserStatus::OPEN);
        $this->updatedOn = $now;
        $this->record(new DispenserOpenedDomainEvent($this->id->value(), $now->format('Y-m-d H:i:s')));
    }

    public function changeStatusClose(DateTime $now): void
    {
        $this->status = new DispenserStatus(DispenserStatus::CLOSE);
        $this->updatedOn = $now;
        $this->record(new DispenserClosedDomainEvent($this->id->value(), $this->updatedOn->format('Y-m-d H:i:s'), $now->format('Y-m-d H:i:s')));
    }
    public function calculateSpending(): void
    {
        $now = new DateTime('now');
        $totalAmount = 0;

        /** @var Usage $usage */
        foreach ($this->usages as $key => $usage) {
            $usage->setFlowVolume($this->flowVolume);
            if (is_null($usage->totalSpent()) || is_null($usage->closedAt())) {
                $timeOpenSeconds = $now->diff($usage->openedAt())->s;
                $usage->setTotalSpent(new UsageTotalSpent($timeOpenSeconds * 12.25));
                $totalAmount += $usage->totalSpent()->value();
            } else {
                $totalAmount += $usage->totalSpent()->value();
            }
            $this->usages[$key] = $usage;
        }
        $this->totalAmount = new DispenserTotalAmount($totalAmount);
    }

    public function id(): DispenserId
    {
        return $this->id;
    }
    public function flowVolume(): DispenserFlowVolume
    {
        return $this->flowVolume;
    }
    public function status(): DispenserStatus
    {
        return $this->status;
    }
    public function createdOn(): DateTime
    {
        return $this->createdOn;
    }
    public function updatedOn(): ?DateTime
    {
        return $this->updatedOn;
    }

    public function setUsages(array $usages): void
    {
        $this->usages = $usages;
    }

    public function usages(): ?array
    {
        return $this->usages;
    }

    public function setTotalAmount(DispenserTotalAmount $totalAmount): void
    {
        $this->totalAmount = $totalAmount;
    }
    public function totalAmount(): ?DispenserTotalAmount
    {
        return $this->totalAmount;
    }

    public function validateOpenDispenser(): void
    {
        if (DispenserStatus::OPEN === $this->status->value()) throw new DispenserAlreadyOpenedException($this->id->value());
    }
    public function validateCloseDispenser(array $usages): UsageId
    {
        
        if (DispenserStatus::CLOSE === $this->status->value()) throw new DispenserAlreadyClosedException($this->id->value());
        if ([] === $usages) throw new DispenserNotGotUsagesException($this->id->value());

        $collection = new ArrayCollection($usages);
        $incompleteUsages = $collection->filter(function (Usage $usage) {
            return (is_null($usage->totalSpent()->value()) && is_null($usage->closedAt()));
        });

        if (0 == $incompleteUsages->count()) throw new DispenserNotGotIncompleteUsageException($this->id->value());
        if (1 < $incompleteUsages->count())  throw new DispenserHasManyIncompleteUsageException($this->id->value());

        return $incompleteUsages->first()->id();
    }

    public function values(): array
    {
        return [
            "id" => $this->id->value(),
            "flowVolume" => $this->flowVolume->value(),
            "status" => $this->status->value(),
            "usages" => $this->usages,
            "createdOn" => $this->createdOn->format('Y-m-d H:i:s'),
            "updatedOn" => !is_null($this->updatedOn) ? $this->updatedOn->format('Y-m-d H:i:s') : null
        ];
    }
}
