<?php

declare(strict_types=1);

namespace App\Service;

use App\GoodsDTO;

class PropertySellDate implements IZero, IDecrease
{

    public function isZero(int $sellIn): bool
    {
        return $sellIn < 0 ? true : false;
    }

    public function decrease(GoodsDTO $goodsDTO, int $count = 1): GoodsDTO
    {
        $sellIn = $goodsDTO->getItemSellIn();
        $sellIn = $sellIn - $count;
        $goodsDTO->setItemSellIn($sellIn);

        return $goodsDTO;
    }

}

