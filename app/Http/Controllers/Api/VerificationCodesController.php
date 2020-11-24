<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\VerificationCodeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Overtrue\EasySms\EasySms;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException;
use Illuminate\Support\Str;

class VerificationCodesController extends Controller
{
    //
    public function store(VerificationCodeRequest $request, EasySms $easySms)
    {
        $captchaData = Cache::get($request->captcha_key);

        if (!$captchaData) {
            return $this->response->error('图片验证码已失效', 401);
        }

        // dump($captchaData['code']);
        // dd($request->captcha_code);

        if (!hash_equals($captchaData['code'], $request->captcha_code)) {
            Cache::forget($request->captcha_key);
            return $this->response->errorUnauthorized('验证码不正确');
        }

        $phone = $captchaData['phone'];

        if (!app()->environment('production')) {
            $code = '1234';
        } else {

            $code = mt_rand(100000, 999999);

            try {
                $result = $easySms->send($phone, [
                    'content' => "【lbbs社区】您的验证码是{$code}"
                ]);
            } catch (NoGatewayAvailableException $e) {
                $message = $e->getException('yunpian');
                return $this->response()->errorInternal($message ?: '发送失败');
            }
        }

        $key = 'verificationCode_' . Str::random(15);
        $expiredAt = now()->addMinutes(10);

        Cache::put($key, ['phone' => $phone, 'code' => $code], $expiredAt);

        Cache::forget($request->captcha_key);

        return $this->response->array([
            'key' => $key,
            'expired_at' => $expiredAt->toDateTimeString()
        ])->setStatusCode(201);
    }
}
