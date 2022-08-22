<?php

namespace App\Http\Controllers;

use App\Mail\SendOtp;
use App\Models\Feedback;
use App\Models\Otp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Swift_TransportException;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validate = Validator($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',

        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors());
        } else {
            $user_details = request()->only([
                'name', 'email',

            ]);



            $user_details['password'] = Hash::make(request()->password);
            $user_details['usertype_id'] = 3;

            $data = User::create($user_details);


            if (!$data->api_token) {
                $tokenResult = $data->createToken('Personal Access Token');
                $token = $tokenResult->accessToken;
                $response = [

                    'user' => $data,
                    'access_token' => $tokenResult->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse(
                        $tokenResult->token->expires_at
                    )->toDateTimeString()
                ];

                User::where('id', $data->id)->update(['api_token' => $token]);
            } else {
                $tokenResult = $data->createToken('Personal Access Token');

                $response = [
                    'user' => $data,
                    'access_token' => $data->api_token,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse(
                        $tokenResult->token->expires_at
                    )->toDateTimeString()
                ];
            }
            $data =  [
                'status' => 200,
                'message' => "Register Sucessfully",
                'output' => $response
            ];
            return $data;
        }
    }

    public function user()
    {
        $user = auth()->user();
        return [
            'status' => 200,
            'message' => 'Login Successfully',
            'output' => User::where('id', $user->id)->withCount('result')->first()
        ];
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        User::where('id', auth()->user()->id)->update(['api_token' => '']);
        $output = [
            'status' => 200,
            'message' => 'Successfully logged out',
            'output' => []
        ];
        return $output;
    }

    public function login(Request $request)
    {
        $validate = Validator($request->all(), [
            'email' => 'required|exists:users,email|email',
            'password' => 'required',

        ], [
            'email.exists' => "No account exist with this email address"
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors());
        } else {
            $user = User::where('email', request()->email)->first();
            if ($user) {
                if (Hash::check(request()->password, $user->password)) {

                    if (!$user->api_token) {
                        $tokenResult = $user->createToken('Personal Access Token');
                        $token = $tokenResult->accessToken;
                        $response = [
                            'user' => $user,
                            'access_token' => $token,
                            'token_type' => 'Bearer',
                            'expires_at' => Carbon::parse(
                                $tokenResult->token->expires_at
                            )->toDateTimeString()
                        ];

                        User::where('id', $user->id)->update(['api_token' => $token]);
                    } else {
                        $tokenResult = $user->createToken('Personal Access Token');

                        $response = [
                            'user' => $user,
                            'access_token' => $user->api_token,
                            'token_type' => 'Bearer',
                            'expires_at' => Carbon::parse(
                                $tokenResult->token->expires_at
                            )->toDateTimeString()
                        ];
                    }

                    $data =  [
                        'status' => 200,
                        'message' => "Login Sucessfully",
                        'output' => $response
                    ];
                } else {
                    $data =  [
                        'status' => 400,
                        'message' => "Password mismatch",
                        'output' => []
                    ];
                }
            } else {
                $data =  [
                    'success' => 400,
                    'message' => "User does not exist",
                    'output' => []
                ];
            }

            return $data;
        }
    }

    public function updateUser(Request $request)
    {

        $user = auth()->user();

        try {
            $user->name = $request->name;
            // $user->email = $request->email;
            $user->save();
            $data = [
                'status' => 200,
                'message' => 'User Detail Updated',
                'output' => $user
            ];
        } catch (\Throwable $th) {
            $data['status'] = '500';
            $data['message'] = 'Please Try Again After Some Time';
            $data['th'] = $th;
        }

        return response()->json($data);
    }

    public function updatePass(Request $request)
    {


        try {
            $user = auth()->user();
            if ($user) {
                if (Hash::check($request->old_pass, $user->password)) {
                    $user->password = Hash::make($request->new_pass);
                    $user->save();
                    $data['status'] = 200;
                    $data['message'] = 'Logged In Successfully';
                    $data['output'] = $user;
                } else {
                    $data['status'] = '203';
                    $data['message'] = "Old Password Doesn't not match. plaese try again!";
                }
            } else {
                $data['status'] = '201';
                $data['message'] = 'Account deactivated please contact admin';
            }
        } catch (\Throwable $th) {
            $data['status'] = '500';
            $data['msg'] = 'Please Try Again After Some Time';
            $data['th'] = $th;
        }

        return response()->json($data);
    }

    public function sendOTP(Request $request)
    {
        $validate = Validator($request->all(), [
            'email' => 'required|unique:users,email|email',


        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors());
        } else {
            try {
                $username = request()->email;
                $otp = rand(100000, 999999);
                if (empty(Otp::where('email', $username)->first())) {
                    $otpLogin = new Otp();
                    $otpLogin->email = $username;
                    $otpLogin->otp = $otp;
                    $otpLogin->save();
                } else {
                    Otp::where('email', $username)->delete();
                    $otpLogin = new Otp();
                    $otpLogin->email = $username;
                    $otpLogin->otp = $otp;
                    $otpLogin->save();
                }

                Mail::to($username)->send(new SendOtp($otp));


                return [
                    'success' => 200,
                    'message' => 'OTP has been sent to your email account',
                    'output'  => []
                ];
            } catch (Swift_TransportException $e) {
                return $e->getMessage();
            } catch (\Exception $e) {
                Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

                $output = [
                    'success' => 400,
                    'message' => "File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage(),
                    'output' => []
                ];
            }
            return $output;
        }
    }

    public function verify(Request $request)
    {
        $validate = Validator($request->all(), [
            'email' => 'required|email|exists:otps,email',
            'otp' => 'required'

        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors());
        } else {
            try {
                $username = request()->email;
                $otp = request()->otp;
                $otpLogin = Otp::where('email', $username)->first();


                if ($otpLogin->otp != $otp) {
                    return [
                        'success' => 400,
                        'message' => 'Incorrect otp',
                        'output' => []
                    ];
                }

                //dd($otp);
                if ($otpLogin->isValidOTPTime) {
                    $otpLogin->delete();
                    return [
                        'success' => 200,
                        'message' => 'Successfully Verified',
                        'output' => []
                    ];
                } else {
                    return [
                        'success' => 400,
                        'message' => 'Otp Verification Failed',
                        'output' => []
                    ];
                }
            } catch (\Exception $e) {
                Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

                $output = [
                    'success' => 400,
                    'message' => "Something went wrong" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage(),
                    'output' => []
                ];
            }

            return $output;
        }
    }

    public function feedback()
    {
        try {
            $input = request()->all();
            $feedback = new Feedback();
            $input['email'] = auth()->user()->email;
            $input['name'] = auth()->user()->name;
            $feedback->create($input);
            return  [
                'status' => 200,
                'message' => "Thank's for your Feedback.",
                'output' => []
            ];
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

            return  [
                'success' => 400,
                'message' => "Something went wrong",
                'output' => []
            ];
        }
    }
}
