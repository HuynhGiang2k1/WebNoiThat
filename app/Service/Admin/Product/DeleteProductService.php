<?php

namespace App\Service\Admin\Product;

use App\Repository\CartRepository;
use App\Repository\ImageRepository;
use App\Repository\ProductRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DeleteProductService
{
    private $model;
    private $repository;
    private $imageRepo;
    private $cartRepo;

    public function __construct(ProductRepository $repository,
                                ImageRepository $imageRepo,
                                CartRepository $cartRepo)
    {
        $this->repository = $repository;
        $this->imageRepo  = $imageRepo;
        $this->cartRepo   = $cartRepo;
    }

    public function handle()
    {
        return DB::transaction(function (){
            $product = $this->repository->getProductById($this->model);
            $this->handleImage($product->id);
            if(File::exists("products/".$product->cover)){
                File::delete("products/".$product->cover);
            }
            $product->subcategories()->detach();
            $product->categories()->detach();
            $this->cartRepo->deleteItemsByProductId($product->id);
            $product->delete();
        });
    }

    public function setModel($id)
    {
        $this->model = $id;

        return $this;
    }

    public function handleImage($productId)
    {
        $images = $this->imageRepo->getImagesByProduct($productId);
        $imagesDelete = $images->get();
        if ($imagesDelete) {
            $imagesDelete->each(function ($image){
                if(File::exists("products/".$image->name)){
                    File::delete("products/".$image->name);
                }
            });
        }
        $images->delete();
    }
}
