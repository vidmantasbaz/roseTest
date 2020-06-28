<?php

declare(strict_types=1);

namespace App\Service;

use App\GoodsDTO;

interface IIncrease
{

    public function increase(GoodsDTO $goodsDTO, int $count = 1): GoodsDTO;
}

