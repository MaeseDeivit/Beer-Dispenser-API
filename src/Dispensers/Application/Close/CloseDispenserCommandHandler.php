<?php

declare(strict_types=1);

namespace App\Dispensers\Application\Close;

use App\Shared\Domain\Uuid\DispenserId;
use App\Shared\Domain\Bus\Command\CommandHandler;
use App\Dispensers\Application\Close\DispenserCloser;
use App\Dispensers\Application\Close\CloseDispenserCommand;

final class CloseDispenserCommandHandler implements CommandHandler
{

    public function __construct(private readonly DispenserCloser $closer)
    {
    }

    public function __invoke(CloseDispenserCommand $command)
    {
        $id         = new DispenserId($command->id());
        $this->closer->__invoke($id);
    }
}
