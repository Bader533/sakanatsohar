<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\UserForgetPasswordEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator(
            $request->all(),
            [
                'name' => 'required | String | max:20',
                'email' => 'required | email | unique:users,email',
                'password' => 'required | String ',
            ]
        );
        if (!$validator->fails()) {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->image_url = $request->input('image');
            $isSaved = $user->save();
            return response()->json(
                [
                    'status' => $isSaved,
                    'message' => $isSaved ? 'Register sucessfully' : 'Registration failed !'
                ],
                $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->getMessageBag()->first()
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function loginPersonal(Request $request)
    {
        $validator = Validator($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:3',
        ]);

        if (!$validator->fails()) {
            $user = User::where('email', $request->input('email'))->first();
            if (Hash::check($request->input('password'), $user->password)) {
                $token = $user->createToken('user');
                $user->setAttribute('token', $token->accessToken);
                return response()->json(
                    [
                        'status' => true,
                        'message' => 'Logged in successfully',
                        'data' => $user,
                        // 'token' => $token
                    ],
                    Response::HTTP_OK,
                );
            } else {
                return response()->json(['message' => 'Login failed, wrong credentials'], Response::HTTP_BAD_REQUEST);
            }
        } else {

            return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }


    public function logout(Request $request)
    {
        $revoked = auth('user-api')->user()->token()->revoke();
        return response()->json(
            [
                'status' => $revoked,
                'message' => $revoked ? 'Logged out successfully' : 'Logout failed!',
            ],
            $revoked ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator(
            $request->all(),
            [
                'email' => 'required | email',
            ]
        );

        if (!$validator->fails()) {
            $code = random_int(1000, 9999);

            $user = User::where('email', '=', $request->input('email'))->first();

            $user->verification_code = Hash::make($code);

            $isSaved = $user->save();

            if ($isSaved) {
                Mail::to($user)->send(new UserForgetPasswordEmail($user, $code));
            }
            return response()->json(
                [
                    'status' => $isSaved,
                    'code' => $code,
                    'message' => $isSaved ? 'Forgot code sent successfully' : 'Forgot code sending failed !'
                ],
                $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->getMessageBag()->first()
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function resetPassword(Request $request)
    {

        $validator = Validator(
            $request->all(),
            [
                'email' => 'required | exists:users,email',
                'code' => 'required | numeric|digits:4',
                'new_password' => 'required',
            ]
        );

        if (!$validator->fails()) {
            $user = User::where('email', '=', $request->input('email'))->first();
            if (!is_null($user->verification_code)) {
                if (Hash::check($request->input('code'), $user->verification_code)) {
                    $user->password = Hash::make($request->input('new_password'));
                    $user->verification_code = null;
                    $isSaved = $user->save();
                    return response()->json(
                        [
                            'status' => $isSaved,
                            'message' => $isSaved ? 'Password change successfully' : 'Password chage failed !'
                        ],
                        $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST
                    );
                } else {
                    return response()->json(
                        [
                            'status' => false,
                            'message' => 'verification code is not correct '
                        ],
                        Response::HTTP_BAD_REQUEST
                    );
                }
            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'No password reset request exist'
                    ],
                    Response::HTTP_FORBIDDEN
                );
            }
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->getMessageBag()->first()
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function changePassword(Request $request)
    {
        $validator = Validator(
            $request->all(),
            [
                'current_password' => 'required | current_password:user-api',
                'new_password' => 'required',
            ]
        );

        if (!$validator->fails()) {
            $user = $request->user('user-api');
            $user->password = Hash::make($request->input('new_password'));
            $isSaved = $user->save();
            return response()->json(
                [
                    'status' => $isSaved,
                    'message' => $isSaved ? 'Password change successfully' : 'Password chage failed !'
                ],
                $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->getMessageBag()->first()
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
