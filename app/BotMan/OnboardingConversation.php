<?php

namespace App\BotMan;

use App\Repository\ProductRepository;
use BotMan\BotMan\Messages\Conversations\Conversation;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class OnboardingConversation extends Conversation
{

    public function run()
    {
        $this->chooseOption();
    }

    private function chooseOption()
    {
        $question = Question::create('Hãy chọn vấn đề bạn quan tâm')
            ->callbackId('option')
            ->addButtons([
                Button::create('Về sản phẩm, cửa hàng')->value('1'),
                Button::create('Về tài khoản')->value('2'),
            ]);

        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                switch ($answer->getValue()) {
                    case '1':
                        $this->askForStore();
                        break;

                    case '2':
                        $this->askForAccount();
                        break;

                    default:
                }
            }
        });
    }

    public function askForStore()
    {
        $question = Question::create('Chọn câu hỏi bạn muốn hỏi')
            ->callbackId('store')
            ->addButtons([
                Button::create('Sản phẩm khuyến mãi')->value('1'),
                Button::create('Gia công theo yêu cầu')->value('2'),
                Button::create('Chi phí lắp đặt')->value('3'),
                Button::create('Chính sách bảo hành')->value('4'),
                Button::create('Địa chỉ cửa hàng')->value('5'),
                Button::create('Mua hàng sẽ thanh toán như thế nào!')->value('6'),
                Button::create('Tôi muốn mua nguyên bộ')->value('7'),
                Button::create('Có một số tiền cụ thể, thì mua được những sản phẩm nào?')->value('8'),
            ]);

        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $this->ansForStore($answer->getValue());
            }
        });
    }

    public function ansForStore($value)
    {
        switch ($value) {
            case '1':
                $this->say("
                    <a href='".route('front.product.sale')."' target='_blank'>Danh sách sản phẩm đang khuyến mãi</a>
                ");
                break;

            case '2':
                $this->say('Chúng tôi có nhận gia công theo yêu cầu, xin vui lòng liên hệ qua đường dây nóng: '.env("SHOP_TEL"));
                break;

            case '3':
                $this->say('Hiện tại chúng tôi miễn phí lắp đặt, nên bạn yên tâm về vấn đề này nhé');
                break;

            case '4':
                $this->say('Thời gian bảo hành sẽ tuỳ thuộc vào sản phẩm bạn mua và giao động từ 1 tháng đến 6 tháng');
                break;

            case '5':
                $this->say('Cửa hàng của chúng tôi nằm ở '.env("SHOP_ADDRESS").'
                        . Bạn có thể đến trực tiếp cửa hàng để chọn sản phẩm ưa thích của mình');
                break;

            case '6':
                $this->say('Hiện tại khi đặt hàng bên chúng thì có thể thanh toán khi nhận hàng hoặc là thanh toán trực tuyến qua VNPAY');
                break;

            case '7':
                $rep = "<a href='".route('front.products', ['bo-suu-tap'])."' target='_blank'>Bộ sưu tâp</a><br>";
                $this->say($rep);
                break;

            case '8':
                $this->ask('Hãy nhập số tiền của bạn!', function(Answer $answer) {
                    preg_match('/(\d+k)|(\d+ng)|(\d+ ng)|(\d+ k)|(\d+tr)|(\d+ tr)|(\d+)/', $answer->getText(), $matches);
                    $price = $matches[0];
                    if (strpos($price, 'k') || strpos($price, 'ng')) {
                        preg_match('/(\d+)/', $price, $mat);
                        $price = $mat[1] * 1000;
                    }else if (strpos($price, 'tr')) {
                        preg_match('/(\d+)/', $price, $mat);
                        $price = $mat[1] * 1000000;
                    }

                    $reply = $this->ansListProductsByPrice('<=', $price);
                    $this->say('Có phải bạn muốn tìm những sản phẩm có giá tiền nhỏ hơn hoặc bằng '
                        .number_format((int)$price, 0, ',', '.').' đ');
                    $this->say($reply);
                });

            default:
        }
    }

    public function askForAccount()
    {
        $question = Question::create('Chọn câu hỏi bạn muốn hỏi')
            ->callbackId('account')
            ->addButtons([
                Button::create('Tôi muốn đăng ký tài khoản')->value('1'),
                Button::create('Tôi muốn đăng nhập')->value('2'),
                Button::create('Tôi muốn lấy lại mật khẩu đã quên')->value('3'),
                Button::create('Tôi muốn đổi mật khẩu')->value('4'),
            ]);

        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $this->ansForAccount($answer->getValue());
            }
        });
    }

    public function ansForAccount($value)
    {
        switch ($value) {
            case '1':
                $rep = "- Để đăng ký tài khoản<br>";
                $rep .= "- Bạn click vào đường dẫn này =>
                            <a href='".route('auth.register')."' target='_blank'>Đăng ký tài khoản</a><br>";
                $rep .= "Chúc bạn thành công!";

                $this->say($rep);
                break;

            case '2':
                $rep = "- Để đăng nhập<br>";
                $rep .= "- Bạn click vào đường dẫn này =>
                            <a href='".route('auth.login')."' target='_blank'>Đăng nhập</a><br>";
                $rep .= "Chúc bạn thành công!";

                $this->say($rep);
                break;

            case '3':
                $rep = "- Để lấy lại mật khẩu<br>";
                $rep .= "- Bạn click vào đường dẫn này =>
                            <a href='".route('password.request')."' target='_blank'>Quên mật khẩu</a><br>";
                $rep .= "- Sau đó nhập email tài khoản của bạn<br>";
                $rep .= "- Đăng nhập vào địa chỉ email vừa nhâp và sẽ nhận được mail để đổi mật khẩu<br>";
                $rep .= "Chúc bạn thành công!";

                $this->say($rep);
                break;

            case '4':
                $rep = "- Để đổi mật khẩu<br>";
                $rep .= "- Bạn click vào đường dẫn này =>
                            <a href='".route('front.user.edit')."' target='_blank'>Thay đổi thông tin cá nhân</a><br>";
                $rep .= "- Sau đó nhập mật khẩu mới và nhấn nút lưu<br>";
                $rep .= "Chúc bạn thành công!";

                $this->say($rep);
                break;

            default:
        }
    }


    private function ansListProductsByPrice($operator, $price)
    {
        if (is_numeric(strpos($operator, 'nhỏ hơn')) || is_numeric(strpos($operator, 'bé hơn'))) {
            $operator = '<';
        } elseif (is_numeric(strpos($operator, 'bằng'))) {
            $operator = '=';
        } elseif(is_numeric(strpos($operator, 'lớn hơn')) || is_numeric(strpos($operator, 'nhiều hơn'))) {
            $operator = '>';
        }
        $products = resolve(ProductRepository::class)->listProductsByPrice($operator, $price);

        return $this->handleMessage($products);
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
