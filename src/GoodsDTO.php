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
        $this->type = Type::OTHER;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getItemQuality(): int
    {
        return $this->item->quality;
    }

    /**
     * @return int
     */
    public function getItemName(): int
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

    /**
     * @param int $quality
     */
    public function setItemQuality(int $quality): void
    {
        $this->item->quality = $quality;
    }

    /**
     * @param int $sell_in
     */
    public function setItemSellIn(int $sell_in): void
    {
        $this->item->sell_in = $sell_in;
    }
}