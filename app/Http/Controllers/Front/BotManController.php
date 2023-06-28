<?php

namespace App\Http\Controllers\Front;

use App\BotMan\OnboardingConversation;
use App\Http\Controllers\Controller;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use http\Message;
use Illuminate\Http\Request;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

        $botman->hears('{message}', function($bot, $message) {
            sleep(1);
            switch ($message) {
                case 'Tôi cần sự trợ giúp':
                    $bot->startConversation(new OnboardingConversation);
                    break;

                default:
                    if (preg_match('/(<|>|=|<=|>=|nhỏ hơn|bé hơn|bằng|lớn hơn|nhiều hơn)\s*((\d+k)|(\d+ng)|(\d+ ng)|(\d+ k)|(\d+tr)|(\d+ tr)|(\d+))/', $message, $matches)) {
                        $operator = $matches[1];
                        $price = $matches[2];
                        if (strpos($price, 'k') || strpos($price, 'ng')) {
                            preg_match('/(\d+)/', $price, $mat);
                            $price = $mat[1] * 1000;
                        }
                        if (strpos($price, 'tr')) {
                            preg_match('/(\d+)/', $price, $mat);
                            $price = $mat[1] * 1000000;
                        }
                        $this->ansListProductsByPrice($bot, $operator, $price);
                        break;
                    }
                    if(preg_match('/((\d+k)|(\d+ng)|(\d+ ng)|(\d+ k)|(\d+tr)|(\d+ tr)|(\d+)).+?(phù hợp|mua được)/', $message, $matches)) {
                        $price = $matches[1];
                        if (strpos($price, 'k') || strpos($price, 'ng')) {
                            preg_match('/(\d+)/', $price, $mat);
                            $price = $mat[1] * 1000;
                        }
                        if (strpos($price, 'tr')) {
                            preg_match('/(\d+)/', $price, $mat);
                            $price = $mat[1] * 1000000;
                        }
                        $this->ansListProductsByPrice($bot, '<=', $price);
                        break;
                    }
                    if(preg_match('/(hi|ello|Hi|in chào)/', $message, $matches)) {
                        $this->askName($bot);
                        break;
                    }
                    if(preg_match('/(mấy giờ)/', $message, $matches)) {
                        $bot->reply('Bây giờ là: '.date('H:i:s', time()));
                        break;
                    }
                    if(preg_match('/(ngày mấy)/', $message, $matches)) {
                        $bot->reply('Hôm nay là ngày: '.date('d/m/Y', time()));
                        break;
                    }
                    if(preg_match('/(?<=mua\s)\p{L}+/u', $message, $matches)) {
                        $this->ansListProductsByKeyWord($bot, $matches[0]);
                        break;
                    }

                    $bot->reply('Xin lỗi, hiện tại tôi không thể trả lời yêu cầu của bạn, hãy hỏi câu hỏi khác!');
            }
        });

        $botman->listen();
    }

    /**
     * Place your BotMan logic here.
     */
    public function askName($bot)
    {
        $bot->ask('Xin chào! Tên bạn là gì?', function(Answer $answer) {

            $name = $answer->getText();

            $this->say('Rất vui được gặp '.$name);
        });
    }

     protected function ansSale($bot)
     {
         $bot->reply("
            <a href='".route('front.product.sale')."' target='_blank'>Ý bạn là những sản phẩm đang được khuyến mãi</a>
         ");
     }

    protected function ansListProductsByPrice($bot, $operator, $price)
    {
        if (is_numeric(strpos($operator, 'nhỏ hơn')) || is_numeric(strpos($operator, 'bé hơn'))) {
            $operator = '<';
        } elseif (is_numeric(strpos($operator, 'bằng'))) {
            $operator = '=';
        } elseif(is_numeric(strpos($operator, 'lớn hơn')) || is_numeric(strpos($operator, 'nhiều hơn'))) {
            $operator = '>';
        }

        $products = resolve(ProductRepository::class)->listProductsByPrice($operator, $price);
        $bot->reply('Có phải bạn muốn tìm những sản phẩm có giá tiền '.$operator. ' ' .number_format($price, 0, ',', '.')).' đ';

        $result = $this->handleMessage($products);

        $bot->reply($result);
    }

    private function ansListProductsByKeyWord($bot, $keyWord)
    {
        $category = resolve(CategoryRepository::class)->getCategoryByName($keyWord);

        if ($category) {
            $bot->reply('
                <a href="'.route('front.products', [$category->name_en]).'" target="_blank">Danh sách sản phẩm '.$keyWord.'</a>
            ');
        } else {
            $bot->reply('Xin lỗi, hiện tại tôi không thể trả lời yêu cầu của bạn, hãy hỏi câu hỏi khác!');
        }
    }

    private function handleMessage($products)
    {
        $message = '';
        foreach ($products as $product) {
            $message .= '
            <div style="display: flex; margin-top: 20px;">
                <img src="'.asset('products/'.$product->cover).'" alt="" style="width: 50px;height: 50px;">
                <div>
                    <a href="'.route('front.product.show', [$product->id]).'" target="_blank">'.$product->name.'</a>
                    <p>'.number_format($product->price, 0, ',', '.').' ₫</p>
                </div>
            </div>
            ';
        }

        return $message;
    }
}
