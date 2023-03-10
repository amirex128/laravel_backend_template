<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgetPassRequest;
use App\Http\Requests\LoginRegisterCustomerRequest;
use App\Http\Requests\LoginRegisterRequest;
use App\Http\Requests\LoginWithCodeRequest;
use App\Http\Requests\LoginWithPassRequest;
use App\Http\Requests\RegisterPassRequest;
use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use SMS;

class CustomerApiAuthController extends Controller
{

    /**
     * @api {put} /customer/:id customer.update
     * @apiName customer.update
     * @apiGroup customer
     * @apiHeader {String} Authorization token
     * @apiBody {String} full_name full_name
     * @apiBody {Number} mobile mobile
     * @apiBody {String} address address
     * @apiBody {Number} postal_code postal_code
     * @apiBody {Number} city_id city_id
     * @apiBody {Number} province_id province_id
     * @apiParam {Number} id model id
     */
    public function loginRegister(LoginRegisterCustomerRequest $request)
    {
        try {
            DB::beginTransaction();
            $customer = User::query()->firstOrCreate([
                'mobile' => $request->mobile,
            ], [
                'full_name' => $request->full_name,
                'mobile' => $request->mobile,
                'address' => $request->address,
                'postal_code' => $request->postal_code,
                'city_id' => $request->city_id,
                'province_id' => $request->province_id,
            ]);

            $diff = Carbon::now()->diffInSeconds($customer->last_send_sms_at);
            if ($diff < 7200 && $diff > 0) {
                $randCode = $customer->verify_code;
                $lastSendSMSAt = $customer->last_send_sms_at;
            } else {
                $randCode = random_int(1000, 9999);
                $lastSendSMSAt = Carbon::now();
            }

            $customer->update([
                'verify_code' => $randCode,
                'last_send_sms_at' => $lastSendSMSAt,
            ]);

            $text = " ???? ???????? ???????????? ?????????? : $randCode";
            $status = SMS::send($request->input('mobile'), $text);

            if (!$status) {
                return response()->json([
                    "message" => "?????? ???? ?????????? ??????????",
                    "is_register" => true,
                    "verify_code" => false,
                ]);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                "message" => "?????? ???? ?????????? ??????????",
                "is_register" => true,
                "verify_code" => false,
            ]);
        }

        return response()->json([
            "message" => "???? ?????????? ???? ?????????? ?????????? ?????? ?????????? ??????????",
            "is_register" => true,
            "verify_code" => true,
        ]);
    }

    public function loginWithCode(LoginWithCodeRequest $request)
    {
        $customer = Customer::query()->where('mobile', $request->mobile)->first();
        if (empty($customer)) {
            return response()->json([
                "message" => "???????????? ???? ?????? ?????????? ???????????? ???????? ??????",
                "is_register" => false,
                "has_password" => false,
                "verify_code" => false,
            ]);
        }
        if ($customer->verify_code != $request->verify_code) {
            return response()->json([
                "message" => "???? ???????? ?????? ???????? ?????? ????????",
                "is_register" => true,
                "has_password" => false,
                "verify_code" => true,
            ]);
        }
        return response()->json([
            "message" => "???????? ???? ???????????? ?????????? ????",
            "is_register" => true,
            "has_password" => false,
            "verify_code" => true,
            "token" => $customer->createToken('authToken')->plainTextToken,
        ]);

    }
}

