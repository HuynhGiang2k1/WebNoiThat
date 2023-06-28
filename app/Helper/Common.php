<?php

namespace App\Helper;

use App\Repository\CartRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;

class Common
{
    public static function getCategories()
    {
        return resolve(CategoryRepository::class)->getCaregoriesWithSub();
    }

    public static function countCartItem()
    {
        return resolve(CartRepository::class)->countCartItem();
    }

    public static function getCartItems()
    {
        return resolve(CartRepository::class)->getItemsByUserId();
    }

    public static function getProductById($id)
    {
        return resolve(ProductRepository::class)->getProductOrderById($id);
    }
}
