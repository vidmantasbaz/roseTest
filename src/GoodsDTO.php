<?php


namespace App;


class GoodsDTO
{
    /**
     * @var Item
     */
    public $item;

    /**
     * @var string
     */
    public $type;


    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getItemQuality(): string
    {
        return $this->item->quality;
    }

    /**
     * @return int
     */
    public function getItem(): int
    {
        return $this->item->name;
    }

    /**
     * @return int
     */
    public function getItemSellIn(): int
    {
        return $this->item->sell_in;
    }
}