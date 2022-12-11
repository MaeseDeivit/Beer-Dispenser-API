<?php

declare(strict_types=1);

namespace App\Usages\Application;

use App\Shared\Domain\Bus\Query\Response;
use App\Usages\Application\UsageResponse;

final class UsagesResponse implements Response
{
    private array $usages;

    public function __construct(UsageResponse ...$usages)
    {
        $this->usages = $usages;
    }

    public function usages(): array
    {
        return $this->usages;
    }
  
}
