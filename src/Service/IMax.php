<?php

declare(strict_types=1);

namespace App\Service;

interface IMax
{

    public function isMaxed(int $value): bool;

}

