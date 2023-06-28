<?php

namespace App\Service\Admin\Product;

use App\Repository\ImageRepository;
use App\Repository\ProductRepository;
use Illuminate\Support\Facades\DB;

class CreateProductService
{
    private $data;
    private $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle()
    {
        DB::transaction(function () {
            $data = $this->handleData();
            $product = $this->repository->createProduct($data);
            collect($this->data->subcategories)->each(function ($subcategoryId) use ($product){
                $product->subcategories()->attach($subcategoryId, ['productable_type' => 'subcategory']);
            });
            collect($this->data->categories)->each(function ($categoryId) use ($product){
                $product->categories()->attach($categoryId, ['productable_type' => 'category']);
            });
            $this->handleImage($product->id);
        });
    }

    public function setData($data)
    {
         $this->data = $data;

         return $this;
    }

    public function handleData()
    {
        if ($this->data->hasFile('cover')){
            $file = $this->data->file("cover");
            $imageName = $file->hashName();
            $file->move(\public_path("products/"), $imageName);
        }

        return [
            'name'          => $this->data->name,
            'size'          => $this->data->size,
            'price'         => $this->data->price,
            'cover'         => $imageName,
            'quantity'      => $this->data->quantity,
            'description'   => $this->data->description,
        ];
    }

    public function handleImage($productId)
    {
        if($this->data->hasFile("images")){
            $files = $this->data->file("images");
            foreach ($files as $file){
                $imageName = $file->hashName();
                $path = $file->move(\public_path("products/"), $imageName);
                resolve(ImageRepository::class)->create([
                    'name' => $imageName,
                    'path' => $path,
                    'product_id' => $productId
                ]);
            }
        }
    }
}
