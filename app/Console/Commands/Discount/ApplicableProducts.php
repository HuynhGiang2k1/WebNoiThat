<?php

namespace App\Console\Commands\Discount;

use App\Repository\DiscountRepository;
use Illuminate\Console\Command;
use App\Repository\ProductRepository;

class ApplicableProducts extends Command
{
    protected $timestamp_today;

    public function __construct()
    {
        parent::__construct();
        $this->timestamp_today = time();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discount:apply';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Apply discount for product';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $initDiscounts = resolve(DiscountRepository::class)->initDiscountsApply($this->timestamp_today);

        $initDiscounts->get()->each(function ($discount){
            resolve(ProductRepository::class)
                ->updateDiscountProductsByIds(json_decode($discount->products_apply), $discount->id);
        });

        $initDiscounts->update(['pickup' => 1]);
    }
}
