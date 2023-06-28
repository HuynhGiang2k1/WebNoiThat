<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Service\Front\Product\ListProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index($category = null, $subcategory = null)
    {
        $categories = resolve(CategoryRepository::class)->getCaregoriesWithSub();

        $products = resolve(ListProductService::class)
            ->setCategory($category)
            ->setSubcategory($subcategory)
            ->handle();

        return view('front.pages.product', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = resolve(ProductRepository::class)->getProductById($id);

        $relatedProducts = resolve(ProductRepository::class)
            ->relatedProducts($id, $product->categories->modelKeys(), $product->subcategories->modelKeys());

        return view('front.pages.product-detail', compact('product', 'relatedProducts'));
    }

    public function search(Request $request)
    {
        $categories = resolve(CategoryRepository::class)->getCaregoriesWithSub();
        $products =  resolve(ProductRepository::class)->searchProducts($request->search);

        return view('front.pages.product', compact('products', 'categories'));
    }

    public function getSale()
    {
        $products = resolve(ProductRepository::class)->getProductsSale();

        return view('front.pages.sale', compact('products'));
    }
}
