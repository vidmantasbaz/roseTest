<?php

declare(strict_types=1);

namespace App\Service;

use App\GoodsDTO;

class PropertyQuality implements IMax, IZero, IDecrease, IIncrease
{
    public function isZero(int $quality): bool
    {
        return $quality === 0 ? true : false;
    }

    public function isMaxed(int $quality): bool
    {
        return $quality === 50 ? true : false;
    }

    public function increase(GoodsDTO $goodsDTO, int $count = 1): GoodsDTO
    {
        $quality = $goodsDTO->getItemQuality();

        $x = 1;
        while ($x <= $count) {
            if (!$this->isMaxed($quality)) {
                $quality = $quality + 1;
                $goodsDTO->setItemQuality($quality);
            }
            $x++;
        }

        return $goodsDTO;
    }

    public function decrease(GoodsDTO $goodsDTO, int $count = 1): GoodsDTO
    {
        $quality = $goodsDTO->getItemQuality();
        $x = 1;
        while ($x <= $count) {
            if (!$this->isZero($quality)) {
                $quality = $quality - 1;
                $goodsDTO->setItemQuality($quality);
            }
            $x++;
        }
        return $goodsDTO;
    }

}

