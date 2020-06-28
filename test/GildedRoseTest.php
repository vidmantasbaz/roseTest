<?php

namespace App;

use App\Service\GoodsService;
use App\Service\PropertyQuality;
use App\Service\PropertySellDate;
use PHPUnit\Framework\MockObject\MockObject;

class GildedRoseTest extends \PHPUnit\Framework\TestCase {

    /** @test */
    public function updateQualityShouldDecreaseForOtherItems() {
        $items      = [new Item("test item", 1, 50)];
        $gildedRose = new GildedRose($items, new GoodsService(new PropertyQuality(), new PropertySellDate()));
        $gildedRose->updateQuality();
        $this->assertEquals(49, $items[0]->quality);
        $this->assertEquals(0, $items[0]->sell_in);
    }

    /** @test */
    public function updateQualityShouldDecreaseTwiceAsFastForOtherItemds() {
        $items      = [new Item("test item", 0, 50)];
        $gildedRose = new GildedRose($items, new GoodsService(new PropertyQuality(), new PropertySellDate()));
        $gildedRose->updateQuality();
        $this->assertEquals(48, $items[0]->quality);
        $this->assertEquals(-1, $items[0]->sell_in);
    }

    /** @test */
    public function updateQualityShouldIncreaseForAgedBrie() {
        $items      = [new Item("Aged Brie of Sometimons", 10, 49)];
        $gildedRose = new GildedRose($items, new GoodsService(new PropertyQuality(), new PropertySellDate()));
        $gildedRose->updateQuality();
        $this->assertEquals(50, $items[0]->quality);
        $this->assertEquals(9, $items[0]->sell_in);
    }

    /** @test */
    public function updateQualityShouldNotIncreaseForAgedBrieIfQualityIsMaxed() {
        $items      = [new Item("Aged Brie of Sometimons", 10, 50)];
        $gildedRose = new GildedRose($items, new GoodsService(new PropertyQuality(), new PropertySellDate()));
        $gildedRose->updateQuality();
        $this->assertEquals(50, $items[0]->quality);
        $this->assertEquals(9, $items[0]->sell_in);
    }

    /** @test */
    public function updateQualityShouldIncreaseForBackstagePasses() {
        $items      = [new Item("Backstage passes, to Good Concert", 20, 30)];
        $gildedRose = new GildedRose($items, new GoodsService(new PropertyQuality(), new PropertySellDate()));
        $gildedRose->updateQuality();
        $this->assertEquals(31, $items[0]->quality);
        $this->assertEquals(19, $items[0]->sell_in);
    }

    /** @test */
    public function updateQualityShouldIncreaseTwiceForBackstagePassesIfSellOutDaysIsLessThen11() {
        $items      = [new Item("Backstage passes, to Good Concert", 11, 30)];
        $gildedRose = new GildedRose($items, new GoodsService(new PropertyQuality(), new PropertySellDate()));
        $gildedRose->updateQuality();
        $this->assertEquals(32, $items[0]->quality);
        $this->assertEquals(10, $items[0]->sell_in);
    }

    /** @test */
    public function updateQualityShouldIncreaseTwiceForBackstagePassesIfSellOutDaysIsLessThen7() {
        $items      = [new Item("Backstage passes, to Good Concert", 6, 30)];
        $gildedRose = new GildedRose($items, new GoodsService(new PropertyQuality(), new PropertySellDate()));
        $gildedRose->updateQuality();
        $this->assertEquals(33, $items[0]->quality);
        $this->assertEquals(5, $items[0]->sell_in);
    }

    /** @test */
    public function updateQualityShouldDecreaseToZeroForBackstagePassesIfSellOutDaysIsLessThenZero() {
        $items      = [new Item("Backstage passes, to Good Concert", 0, 30)];
        $gildedRose = new GildedRose($items, new GoodsService(new PropertyQuality(), new PropertySellDate()));
        $gildedRose->updateQuality();
        $this->assertEquals(0, $items[0]->quality);
        $this->assertEquals(-1, $items[0]->sell_in);
    }

    /** @test */
    public function updateQualityShouldNotDecreaseForSulfuras() {
        $items      = [new Item("Sulfuras, Hand of Ragnaros", 0, 80)];
        /** @var MockObject|GoodsService $goodService */
        $goodService = $this->createMock(GoodsService::class);
        $gildedRose = new GildedRose($items, $goodService);
        $gildedRose->updateQuality();
        $this->assertEquals(80, $items[0]->quality);
    }

    /** @test */
    public function updateQualityShouldDecreaseTwiceAsFastForConjured() {
        $items      = [new Item("Conjured toy", 10, 30)];
        $gildedRose = new GildedRose($items, new GoodsService(new PropertyQuality(), new PropertySellDate()));
        $gildedRose->updateQuality();
        $this->assertEquals(28, $items[0]->quality);
        $this->assertEquals(9, $items[0]->sell_in);
    }

    /** @test */
    public function updateQualityShouldDecreaseTwiceAsFastForConjuredAndTwiceAsFastAfterSellByDatePassed() {
        $items      = [new Item("Conjured toy", 0, 30)];
        $gildedRose = new GildedRose($items, new GoodsService(new PropertyQuality(), new PropertySellDate()));
        $gildedRose->updateQuality();
        $this->assertEquals(26, $items[0]->quality);
        $this->assertEquals(-1, $items[0]->sell_in);
    }

    /** @test */
    public function updateQualityShouldDecreaseButQualityNotGoInNegative() {
        $items      = [new Item("Conjured stick", 0, 3)];
        $gildedRose = new GildedRose($items, new GoodsService(new PropertyQuality(), new PropertySellDate()));
        $gildedRose->updateQuality();
        $this->assertEquals(0, $items[0]->quality);
        $this->assertEquals(-1, $items[0]->sell_in);
    }
}
