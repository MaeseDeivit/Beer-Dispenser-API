<?php

declare(strict_types=1);

namespace App\Dispensers\Application\Open;

use App\Shared\Domain\Uuid\DispenserId;
use App\Shared\Domain\Bus\Command\CommandHandler;
use App\Dispensers\Application\Open\DispenserOpener;

final class OpenDispenserCommandHandler implements CommandHandler
{

    public function __construct(private readonly DispenserOpener $opener)
    {
    }

    public function __invoke(OpenDispenserCommand $command)
    {
        $id         = new DispenserId($command->id());

        $this->opener->__invoke($id);
    }
}
