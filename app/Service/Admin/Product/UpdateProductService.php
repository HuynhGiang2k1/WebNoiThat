<?php

namespace App\Service\Admin\Product;

use App\Repository\ImageRepository;
use App\Repository\ProductRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class UpdateProductService
{
    private $data;
    private $model;
    private $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle()
    {
        $product = $this->repository->getProductById($this->model);

        DB::transaction(function () use ($product) {
            $data = $this->handleData($product);
            $this->repository->updateProduct($this->model, $data);
            $product->subcategories()->detach();
            $product->categories()->detach();
            collect($this->data->subcategories)->each(function ($subcategoryId) use ($product){
                $product->subcategories()->attach($subcategoryId, ['productable_type' => 'subcategory']);
            });
            collect($this->data->categories)->each(function ($categoryId) use ($product){
                $product->categories()->attach($categoryId, ['productable_type' => 'category']);
            });
            $this->handleImage($product->id);
        });
    }

    public function handleData($product)
    {
        if ($this->data->hasFile('cover')){
            if(File::exists("products/".$product->cover)){
                File::delete("products/".$product->cover);
            }
            $file = $this->data->file("cover");
            $imageName = $file->hashName();
            $file->move(\public_path("products/"), $imageName);
        }

        return [
            'name'          => $this->data->name,
            'size'          => $this->data->size,
            'price'         => $this->data->price,
            'cover'         => $imageName ?? $product->cover,
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

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }
}
