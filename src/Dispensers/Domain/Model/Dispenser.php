<?php

declare(strict_types=1);

namespace App\Dispensers\Domain\Model;

use DateTime;
use App\Shared\Domain\Uuid\DispenserId;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Dispensers\Domain\Model\DispenserStatus;
use App\Dispensers\Domain\Model\DispenserCreatedOn;
use App\Dispensers\Domain\Model\DispenserUpdatedOn;
use App\Dispensers\Domain\Model\DispenserFlowVolume;

class Dispenser extends AggregateRoot
{
    public function __construct(
        private readonly DispenserId $id,
        private readonly DispenserFlowVolume $flowVolume,
        private readonly DispenserStatus $status,
        private readonly DateTime $createdOn,
        private readonly ?DispenserUpdatedOn $updatedOn
    ) {
    }
    public static function create(
        DispenserId $id,
        DispenserFlowVolume $flowVolume
    ): self {
        $dispenser = new self($id, $flowVolume, new DispenserStatus(DispenserStatus::CLOSE), new DateTime('now'), null);
        // $dispenser->record(new DispenserCreatedDomainEvent($id, $flowVolume, $status, $createdOn));

        return $dispenser;
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

    public function values(): array
    {
        return [
            "id" => $this->id->value(),
            "flowVolume" => $this->flowVolume->value(),
            "status" => $this->status->value(),
            "createdOn" => $this->createdOn,
            "updatedOn" => !is_null($this->updatedOn) ? $this->updatedOn->__toString() : null
        ];
    }
}
