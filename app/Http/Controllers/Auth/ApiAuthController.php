<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgetPassRequest;
use App\Http\Requests\LoginRegisterRequest;
use App\Http\Requests\LoginWithCodeRequest;
use App\Http\Requests\LoginWithPassRequest;
use App\Http\Requests\RegisterPassRequest;
use App\Models\User;
use Carbon\Carbon;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use SMS;

class ApiAuthController extends Controller
{

    public function loginRegister(LoginRegisterRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = User::query()->firstOrCreate([
                'mobile' => $request->mobile,
            ], []);

            if (!empty($user->password)) {
                return response()->json([
                    "message" => "لطفا گذرواژه خود را برای ورود وارد نمایید",
                    "is_register" => true,
                    "has_password" => true,
                    "verify_code" => false,
                ]);
            }

            $diff = Carbon::now()->diffInSeconds($user->last_send_sms_at);
            if ($diff < 7200 && $diff > 0) {
                $randCode = $user->verify_code;
                $lastSendSMSAt = $user->last_send_sms_at;
            } else {
                $randCode = random_int(1000, 9999);
                $lastSendSMSAt = Carbon::now();
            }

            $user->update([
                'verify_code' => $randCode,
                'last_send_sms_at' => $lastSendSMSAt,
            ]);

            $text = " کد ورود سامانه سلورا : $randCode";
            $status = SMS::send($request->input('mobile'), $text);

            if (!$status) {
                return response()->json([
                    "message" => "خطا در ارسال پیامک",
                    "is_register" => true,
                    "has_password" => false,
                    "verify_code" => false,
                ]);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                "message" => "خطا در ارسال پیامک",
                "is_register" => true,
                "has_password" => false,
                "verify_code" => false,
            ]);
        }

        return response()->json([
            "message" => "کد تایید به شماره همراه شما ارسال گردید",
            "is_register" => true,
            "has_password" => false,
            "verify_code" => true,
        ]);
    }

    public function loginWithCode(LoginWithCodeRequest $request)
    {
        $user = User::query()->where('mobile', $request->mobile)->first();
        if (empty($user)) {
            return response()->json([
                "message" => "کاربری با این شماره موبایل یافت نشد",
                "is_register" => false,
                "has_password" => false,
                "verify_code" => false,
            ]);
        }
        if ($user->verify_code != $request->verify_code) {
            return response()->json([
                "message" => "کد وارد شده صحیح نمی باشد",
                "is_register" => true,
                "has_password" => false,
                "verify_code" => true,
            ]);
        }
        return response()->json([
            "message" => "ورود با موفقیت انجام شد",
            "is_register" => true,
            "has_password" => false,
            "verify_code" => true,
            "token" => $user->createToken('authToken')->plainTextToken,
        ]);

    }

    public function loginWithPass(LoginWithPassRequest $request)
    {
        $user = User::query()->where('mobile', $request->mobile)->first();
        if (empty($user)) {
            return response()->json([
                "message" => "کاربری با این شماره موبایل یافت نشد",
                "is_register" => false,
                "has_password" => false,
                "verify_code" => false,
            ]);
        }
        if (!Auth::attempt($request->only('mobile', 'password'))) {
            return response()->json([
                "message" => "رمز عبور صحیح نمی باشد",
                "is_register" => true,
                "has_password" => true,
                "verify_code" => false,
            ]);
        }
        return response()->json([
            "message" => "ورود با موفقیت انجام شد",
            "is_register" => true,
            "has_password" => true,
            "verify_code" => false,
            "token" => $user->createToken('authToken')->plainTextToken,
        ]);

    }

    public function registerPass(RegisterPassRequest $request)
    {
        $request->user()->update([
            'password' => bcrypt($request->password),
        ]);
        return response()->json([
            "message" => "ثبت گذرواژه با موفقیت انجام شد",
            "is_register" => true,
            "has_password" => true,
            "verify_code" => true]);

    }

    public function forgetPass(ForgetPassRequest $request)
    {
        $user = User::query()->where('mobile', $request->mobile)->first();
        if (empty($user)) {
            return response()->json([
                "message" => "کاربری با این شماره موبایل یافت نشد",
                "is_register" => false,
                "has_password" => false,
                "verify_code" => false,
            ]);
        }
        $diff = Carbon::now()->diffInSeconds($user->last_send_sms_at);
        if ($diff < 7200 && $diff > 0) {
            $randCode = $user->verify_code;
            $lastSendSMSAt = $user->last_send_sms_at;
        } else {
            $randCode = random_int(1000, 9999);
            $lastSendSMSAt = Carbon::now();
        }

        $user->update([
            'verify_code' => $randCode,
            'last_send_sms_at' => $lastSendSMSAt,
        ]);
        $text = " کد ورود سامانه سلورا : $randCode";
        $status = SMS::send($request->input('mobile'), $text);
        if (!$status) {
            return response()->json([
                "message" => "خطا در ارسال پیامک",
                "is_register" => true,
                "has_password" => false,
                "verify_code" => false,
            ]);
        }
        return response()->json([
            "message" => "کد تایید به شماره همراه شما ارسال گردید",
            "is_register" => true,
            "has_password" => false,
            "verify_code" => true,
        ]);

    }
}

