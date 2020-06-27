<?php

declare(strict_types=1);

namespace App\Service;

use App\GoodsDTO;
use App\Type;

class GoodsService {

    /**
     * @var PropertyQuality
     */
    public $propertyQuality;
    /**
     * @var PropertySellDate
     */
    public $propertySellDate;

    /**
     * GoodsService constructor.
     * @param PropertyQuality $propertyQuality
     * @param PropertySellDate $propertySellDate
     */
    public function __construct(PropertyQuality $propertyQuality, PropertySellDate $propertySellDate)
    {
        $this->propertyQuality= $propertyQuality;
        $this->propertySellDate= $propertySellDate;
    }

    /**
     * @param GoodsDTO $goodsDTO
     * @return GoodsDTO
     */
    public function determineType(GoodsDTO $goodsDTO): GoodsDTO
    {
        $name = $goodsDTO->getItemName();

        foreach (Type::$map as $type) {
            if (strpos($name, $type) !== false) {
                $goodsDTO->setType($type);
                return $goodsDTO;
            }
        }
        return $goodsDTO;
    }

    /**
     * @param GoodsDTO $goodsDTO
     * @return GoodsDTO
     */
    public function updateOtherGoods(GoodsDTO $goodsDTO): GoodsDTO
    {
        $goodsDTO = $this->propertySellDate->decrease($goodsDTO);

        $count = 1;
        if($this->propertySellDate->isZero($goodsDTO->getItemSellIn())) {
            $count = 2;
        }
        $goodsDTO = $this->propertyQuality->decrease($goodsDTO, $count);

        return $goodsDTO;
    }

    /**
     * @param GoodsDTO $goodsDTO
     * @return GoodsDTO
     */
    public function updateConjuredGoods(GoodsDTO $goodsDTO): GoodsDTO
    {
        $goodsDTO = $this->propertySellDate->decrease($goodsDTO);

        $count = 2;
        if($this->propertySellDate->isZero($goodsDTO->getItemSellIn())) {
            $count = 4;
        }
        $goodsDTO = $this->propertyQuality->decrease($goodsDTO, $count);


        return $goodsDTO;
    }

    /**
     * @param GoodsDTO $goodsDTO
     * @return GoodsDTO
     */
    public function updateAgedBrieGoods(GoodsDTO $goodsDTO): GoodsDTO
    {
        $goodsDTO = $this->propertySellDate->decrease($goodsDTO);

        $goodsDTO = $this->propertyQuality->increase($goodsDTO);

        return $goodsDTO;
    }

    /**
     * @param GoodsDTO $goodsDTO
     * @return GoodsDTO
     */
    public function updateBackstagePassesGoods(GoodsDTO $goodsDTO): GoodsDTO
    {
        $goodsDTO = $this->propertySellDate->decrease($goodsDTO);
        $sellIn = $goodsDTO->getItemSellIn();
        if($this->propertySellDate->isZero($sellIn)) {
            $goodsDTO->setItemQuality(0);
            return $goodsDTO;
        }

        if ($sellIn < 6) {
            return $this->propertyQuality->increase($goodsDTO, 3);
        }

        if ($sellIn < 11) {
            return $this->propertyQuality->increase($goodsDTO, 2);
        }

        return $this->propertyQuality->increase($goodsDTO, 1);
    }

}

