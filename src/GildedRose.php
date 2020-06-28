<?php

declare(strict_types=1);

namespace App;

use App\Service\GoodsService;

final class GildedRose
{

    /**
     * @var Item[]
     */
    private $items = [];

    /**
     * @var GoodsService
     */
    private $goodsService;

    public function __construct(array $items, GoodsService $goodsService)
    {
        $this->items = $items;
        $this->goodsService = $goodsService;
    }

    public function updateQuality()
    {
        foreach ($this->items as $item) {
            $goods = $this->goodsService->determineType(new GoodsDTO($item));
            switch ($goods->getType()) {
                case Type::BACKSTAGE_PASS:
                    $this->goodsService->updateBackstagePassesGoods($goods);
                    break;
                case Type::SULFURAS:
                    break;
                case Type::AGED_BRIE:
                    $this->goodsService->updateAgedBrieGoods($goods);
                    break;
                case Type::CONJURED:
                    $this->goodsService->updateConjuredGoods($goods);
                    break;
                default:
                    $this->goodsService->updateOtherGoods($goods);
            }
        }
    }
}

