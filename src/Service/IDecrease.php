<?php

declare(strict_types=1);

namespace App\Service;

use App\GoodsDTO;

interface IDecrease
{
    public function decrease(GoodsDTO $goodsDTO, int $count = 1): GoodsDTO;

}

