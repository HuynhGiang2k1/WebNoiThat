<?php

namespace App\Service\Front\Product;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\SubCategoryRepository;

class ListProductService
{
    protected $repository;
    protected $category;
    protected $subcategory;
    protected $categoryRepo;
    protected $subcategoryRepo;


    public function __construct(ProductRepository $repository,
                                CategoryRepository $categoryRepo,
                                SubCategoryRepository $subcategoryRepo)
    {
        $this->repository = $repository;
        $this->categoryRepo = $categoryRepo;
        $this->subcategoryRepo = $subcategoryRepo;
    }

    public function handle()
    {
        if ($this->category) {
            $category = $this->categoryRepo->getCategoryByName($this->category);
            if (!$category) {
                abort(404);
            }
        }

        if ($this->subcategory) {
            $subcategory = $this->subcategoryRepo->getSubCategoryByName($this->subcategory);

            if (!$subcategory || $subcategory->category->id != $category->id) {
                abort(404);
            }

            return $this->repository->getProducts([$subcategory->id]);
        } else {
            if ($this->category) {
                $subcategoryIds = $category->subcategories->modelKeys();

                return $this->repository->getProducts($subcategoryIds, $category->id);
            }
        }

        return $this->repository->getProducts();
    }

    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    public function setSubcategory($subcategory)
    {
        $this->subcategory = $subcategory;

        return $this;
    }
}
