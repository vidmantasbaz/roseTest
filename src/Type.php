<?php


namespace App;
class Type
{
    public const AGED_BRIE = 'Aged Brie';
    public const SULFURAS = 'Sulfuras';
    public const BACKSTAG4E_PASS = 'Backstage passes';
    public const CONJURED = 'Conjured';
    public const OTHER = 'other';

    public static $map = [
        self::AGED_BRIE,
        self::SULFURAS,
        self::BACKSTAG4E_PASS,
        self::CONJURED
    ];
}