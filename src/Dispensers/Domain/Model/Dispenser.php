<?php

declare(strict_types=1);

namespace App\Dispensers\Domain\Model;

use DateTime;
use App\Usages\Domain\Model\Usage;
use App\Shared\Domain\Uuid\DispenserId;
use Doctrine\Common\Collections\Collection;
use App\Usages\Domain\Model\UsageTotalSpent;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Dispensers\Domain\Model\DispenserStatus;
use App\Dispensers\Domain\Model\DispenserCreatedOn;
use App\Dispensers\Domain\Model\DispenserUpdatedOn;
use App\Dispensers\Domain\Model\DispenserFlowVolume;
use App\Dispensers\Domain\Model\DispenserTotalAmount;
use App\Dispensers\Domain\Events\DispenserCreatedDomainEvent;

class Dispenser extends AggregateRoot
{
    private DispenserTotalAmount $totalAmount;

    public function __construct(
        private readonly DispenserId $id,
        private readonly DispenserFlowVolume $flowVolume,
        private readonly DispenserStatus $status,
        private readonly DateTime $createdOn,
        private readonly ?DispenserUpdatedOn $updatedOn,
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
    public function updatedOn(): ?DispenserUpdatedOn
    {
        return $this->updatedOn;
    }

    public function setUsages(array $usages): void
    {
        $this->usages = $usages;
    }

    public function usages(): array
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

    public function values(): array
    {
        return [
            "id" => $this->id->value(),
            "flowVolume" => $this->flowVolume->value(),
            "status" => $this->status->value(),
            "usages" => $this->usages,
            "createdOn" => $this->createdOn->format('Y-m-d H:i:s'),
            "updatedOn" => !is_null($this->updatedOn) ? $this->updatedOn->__toString() : null
        ];
    }
}
