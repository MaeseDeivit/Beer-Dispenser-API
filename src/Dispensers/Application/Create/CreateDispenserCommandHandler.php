<?php

declare(strict_types=1);

namespace App\Dispensers\Application\Create;

use App\Shared\Domain\Bus\Command\CommandHandler;
use App\Dispensers\Application\Create\DispenserCreator;
use App\Dispensers\Application\Create\CreateDispenserCommand;
use App\Dispensers\Domain\Model\ValueObject\DispenserFlowVolume;
use App\Shared\Domain\Uuid\DispenserId;

final class CreateDispenserCommandHandler implements CommandHandler
{

    public function __construct(private readonly DispenserCreator $creator)
    {
    }

    public function __invoke(CreateDispenserCommand $command)
    {
        $id         = new DispenserId($command->id());
        $flowVolume = new DispenserFlowVolume($command->flowVolume());

        $this->creator->__invoke($id, $flowVolume);
    }
}
