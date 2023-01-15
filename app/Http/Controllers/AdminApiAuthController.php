<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgetPassRequest;
use App\Http\Requests\LoginRegisterRequest;
use App\Http\Requests\LoginWithCodeRequest;
use App\Http\Requests\LoginWithPassRequest;
use App\Http\Requests\RegisterPassRequest;
use App\Models\Admin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use SMS;

class AdminApiAuthController extends Controller
{
    public function loginWithPass(LoginWithPassRequest $request)
    {
        $admin = Admin::query()->where('mobile', $request->mobile)->first();
        if (empty($admin)) {
            return response()->json([
                "message" => "کاربری با این شماره موبایل یافت نشد",
                "is_register" => false,
                "has_password" => false,
                "verify_code" => false,
            ]);
        }


        if ($request->mobile == $admin->mobile && Hash::check($request->password, $admin->password)) {
            return response()->json([
                "message" => "ورود با موفقیت انجام شد",
                "is_register" => true,
                "has_password" => true,
                "verify_code" => false,
                "token" => $admin->createToken('authToken')->plainTextToken,
            ]);
        }
        return response()->json([
            "message" => "رمز عبور صحیح نمی باشد",
            "is_register" => true,
            "has_password" => true,
            "verify_code" => false,
        ]);


    }
}

