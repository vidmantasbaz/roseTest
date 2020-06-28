<?php

declare(strict_types=1);

namespace App\Service;

use App\GildedRose;
use App\GoodsDTO;
use App\Item;
use App\Type;
use PHPUnit\Framework\MockObject\MockObject;

class GoodsServiceTest extends \PHPUnit\Framework\TestCase {

    /**
     * @var MockObject|PropertyQuality
     */
    private $propertyQuality;
    /**
     * @var MockObject|PropertySellDate
     */
    private $propertySellDate;


    protected function setUp(): void
    {
        $this->propertyQuality = $this->createMock(PropertyQuality::class);
        $this->propertySellDate = $this->createMock(PropertySellDate::class);
    }

    /** @test */
    public function determineTypeShouldSetOtherType()
    {
        $goodsDto = new GoodsDTO(new Item("test item", 1, 50));

        $service = new GoodsService($this->propertyQuality, $this->propertySellDate);
        $result = $service->determineType($goodsDto);
        $this->assertSame(Type::OTHER, $result->getType());
    }

    /** @test */
    public function determineTypeShouldSetBackStageType()
    {
        $goodsDto = new GoodsDTO(new Item("Backstage passes to Wonderland", 1, 50));

        $service = new GoodsService($this->propertyQuality, $this->propertySellDate);
        $result = $service->determineType($goodsDto);
        $this->assertSame(Type::BACKSTAGE_PASS, $result->getType());
    }

    /** @test */
    public function updateOtherGoodsShouldDecreaseQualityOneTime()
    {
        $goodsDto = new GoodsDTO(new Item("test passes to Wonderland", 1, 50));
        $expectedDto = new GoodsDTO(new Item("test passes to Wonderland", 0, 50));
        $expectedDto2 = new GoodsDTO(new Item("test passes to Wonderland", 0, 49));
        $this->propertySellDate->expects($this->at(0))->method('decrease')->willReturn($expectedDto);
        $this->propertySellDate->expects($this->at(1))->method('isZero')->willReturn(false);
        $this->propertyQuality
            ->expects($this->once())
            ->method('decrease')
            ->with($expectedDto, 1
            )->willReturn($expectedDto2);
        $service = new GoodsService($this->propertyQuality, $this->propertySellDate);

        $service->updateOtherGoods($goodsDto);

    }

    /** @test */
    public function updateOtherGoodsShouldDecreaseQualityTwoTime()
    {
        $goodsDto = new GoodsDTO(new Item("test passes to Wonderland", 1, 50));
        $expectedDto = new GoodsDTO(new Item("test passes to Wonderland", 0, 50));
        $expectedDto2 = new GoodsDTO(new Item("test passes to Wonderland", 0, 48));
        $this->propertySellDate->expects($this->at(0))->method('decrease')->willReturn($expectedDto);
        $this->propertySellDate->expects($this->at(1))->method('isZero')->willReturn(true);
        $this->propertyQuality
            ->expects($this->once())
            ->method('decrease')
            ->with($expectedDto, 2)
            ->willReturn($expectedDto2);
        $service = new GoodsService($this->propertyQuality, $this->propertySellDate);

       $result =  $service->updateOtherGoods($goodsDto);

       $this->assertSame($expectedDto2, $result);
    }

    /** @test */
    public function updateConjuredGoods()
    {
        $goodsDto = new GoodsDTO(new Item("Conjured ROD", 1, 50));
        $expectedDto = new GoodsDTO(new Item("Conjured ROD", 0, 50));
        $expectedDto2 = new GoodsDTO(new Item("Conjured ROD", 0, 46));
        $this->propertySellDate->expects($this->at(0))->method('decrease')->willReturn($expectedDto);
        $this->propertySellDate->expects($this->at(1))->method('isZero')->willReturn(true);
        $this->propertyQuality
            ->expects($this->once())
            ->method('decrease')
            ->with($expectedDto, 4)
            ->willReturn($expectedDto2);
        $service = new GoodsService($this->propertyQuality, $this->propertySellDate);

       $result =  $service->updateConjuredGoods($goodsDto);

       $this->assertSame($expectedDto2, $result);
    }

    /** @test */
    public function updateAgedBrieGoods()
    {
        $goodsDto = new GoodsDTO(new Item("Conjured ROD", 1, 49));
        $expectedDto = new GoodsDTO(new Item("Conjured ROD", 0, 49));
        $expectedDto2 = new GoodsDTO(new Item("Conjured ROD", 0, 50));
        $this->propertySellDate->expects($this->once())->method('decrease')->willReturn($expectedDto);
        $this->propertyQuality
            ->expects($this->once())
            ->method('increase')
            ->with($expectedDto)
            ->willReturn($expectedDto2);

        $service = new GoodsService($this->propertyQuality, $this->propertySellDate);

        $result =  $service->updateAgedBrieGoods($goodsDto);

        $this->assertSame($expectedDto2, $result);
    }

    /** @test */
    public function updateBackstagePassesGoodShouldSellInPastZeroQualityZero()
    {
        $goodsDto = new GoodsDTO(new Item("Backstage passes to a TAFKAL80ETC", 0, 49));
        $expectedDto = new GoodsDTO(new Item("Conjured ROD", -1, 0));
        $this->propertySellDate->expects($this->at(0))->method('decrease')->willReturn($expectedDto);
        $this->propertySellDate
            ->expects($this->at(1))
            ->method('isZero')
            ->with(-1)
            ->willReturn(true);

        $service = new GoodsService($this->propertyQuality, $this->propertySellDate);

        $service->updateBackstagePassesGoods($goodsDto);

    }
    /** @test */
    public function updateBackstagePassesGoodsShouldIncreaseInQuality()
    {
        $goodsDto = new GoodsDTO(new Item("Backstage passes to a TAFKAL80ETC", 1, 49));
        $expectedDto = new GoodsDTO(new Item("Conjured ROD", 0, 49));
        $expectedDto2 = new GoodsDTO(new Item("Conjured ROD", 0, 50));
        $this->propertySellDate->expects($this->at(0))->method('decrease')->willReturn($expectedDto);
        $this->propertySellDate
            ->expects($this->at(1))
            ->method('isZero')
            ->with(0)
            ->willReturn(false);
        $this->propertyQuality
            ->expects($this->once())
            ->method('increase')
            ->with($expectedDto, 3)
            ->willReturn($expectedDto2);

        $service = new GoodsService($this->propertyQuality, $this->propertySellDate);

        $service->updateBackstagePassesGoods($goodsDto);

    }
}

