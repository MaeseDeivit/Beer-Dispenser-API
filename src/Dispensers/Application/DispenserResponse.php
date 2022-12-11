<?php

declare(strict_types=1);

namespace App\Dispensers\Application;

use App\Usages\Domain\Model\Usage;
use App\Shared\Domain\Bus\Query\Response;
use App\Usages\Application\UsageResponse;

final class DispenserResponse implements Response
{
    public function __construct(
        private string $id,
        private float $flowVolume,
        private float $amount,
        private string $status,
        private string $createdOn,
        private ?string $updatedOn,
        private array $usages
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }
    public function flowVolume(): float
    {
        return $this->flowVolume;
    }
    public function amount(): float
    {
        return $this->amount;
    }
    public function status(): string
    {
        return $this->status;
    }
    public function createdOn(): string
    {
        return $this->createdOn;
    }
    public function updatedOn(): ?string
    {
        return $this->updatedOn;
    }
    public function usages(): array
    {
        return $this->usages;
    }
    public function usagesValues(): array
    {
        $usagesValues = [];

        /** @var Usage $usage */
        foreach ($this->usages as $usage) {
            $usageResponse = new UsageResponse(
                $usage->id()->value(),
                $usage->flowVolume()->value(),
                $usage->totalSpent()->value(),
                $usage->openedAt()->format('Y-m-d H:i:s'),
                !is_null($usage->closedAt()) ? $usage->closedAt()->format('Y-m-d H:i:s') : null
            );
            $usagesValues[] = $usageResponse->values();
        };
        return $usagesValues;
    }
    public function values(): array
    {
        return [
            'id'                            => $this->id(),
            'flow_volume'                    => $this->flowVolume(),
            'amount'                        => $this->amount(),
            'status'                        => $this->status(),
            'created_on'                     => $this->createdOn(),
            'updated_on'                     => $this->updatedOn(),
            'usages'                        => $this->usagesValues()
        ];
    }
}
