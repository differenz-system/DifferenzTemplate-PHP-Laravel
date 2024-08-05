<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\ForgotPassword;
use Illuminate\Http\Request;
use App\Models\ForgotPasswordToken;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserAPIController extends Controller
{
    /**
     * @OA\Schema(
     *     schema="Registration",
     *     @OA\Property(property="FirstName", type="string"),
     *     @OA\Property(property="LastName", type="string"),
     *     @OA\Property(property="Email", type="string"),
     *     @OA\Property(property="Password", type="string"),
     *     @OA\Property(property="ProfilePicture", type="string", format="binary"),
     *     @OA\Property(property="DeviceType", type="integer", example=1, description="Device Type: 1 - IOS, 2 - Android, 3 - Website, 4 - Admin"),
     *     @OA\Property(property="DeviceToken", type="string"),
     *     @OA\Property(property="SocialType", type="integer", example=0, description="Social Type: 0 - Default, 1 - Facebook, 2 - Google"),
     *     @OA\Property(property="SocialIdentifier", type="string")
     * )
     * @OA\Post(
     *     path="/Registration",
     *     operationId="Registration",
     *     tags={"User"},
     *     summary="Registration Process",
     *     description="DeviceType: 1 IOS, 2 Android, 3 Website, 4 Admin",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(ref="#/components/schemas/Registration")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Registration successfully."),
     *     @OA\Response(response=400, description="Something went wrong"),
     *     @OA\Response(response=101, description="Email is required."),
     *     @OA\Response(response=102, description="Email already exists.")
     * )
     */


    public function Registration(Request $request)
    {
        if ($request->Email != '') {
            $CheckEmail = User::where('Email', $request->Email)->where('IsDelete', 0)->first();
            if (!$CheckEmail) {
                $UserId = $this->GenerateUniqueRandomString($table = "users", $column = "UserId", $chars = 32);
                $Token = $this->GetnewToken();
                $Image = $this->UploadImage($file = $request->ProfilePicture, $path = storage_path('/web/images/profile'));

                $result = User::create([
                    'UserId'           => $UserId,
                    'Role'             => 1, // For user
                    'FirstName'        => $request->FirstName,
                    'LastName'         => $request->LastName,
                    'Email'            => $request->Email,
                    'Password'         => bcrypt($request->Password),
                    'AuthToken'        => $Token,
                    'DeviceToken'      => ($request->DeviceToken == '') ? '' : $request->DeviceToken,
                    'DeviceType'       => $request->DeviceType,
                    'SocialType'       => ($request->SocialType == '') ? 0 : $request->SocialType,
                    'SocialIdentifier' => ($request->SocialIdentifier == '') ? '' : $request->SocialIdentifier,
                    'ProfilePicture'   => $Image,
                    'IsDelete'         => 0,
                ]);
                if ($result->exists) {
                    $data = $this->UserResponse($result);
                    return $this->SuccessResponse(true, 200, 'User registered successfully.', $data);
                } else {
                    return $this->ErrorResponse(false, 400, 'Something went wrong.', new \stdClass());
                }
            } else {
                return $this->ErrorResponse(false, 102, 'Email is already exist.', new \stdClass());
            }
        } else {
            return $this->ErrorResponse(false, 101, 'Email is required.', new \stdClass());
        }
    }

    /**
     * @OA\Schema(
     *     schema="Login",
     *     @OA\Property(property="Email", type="string"),
     *     @OA\Property(property="Password", type="string"),
     *     @OA\Property(property="SocialType", type="integer", example=0),
     *     @OA\Property(property="SocialIdentifier", type="string"),
     *     @OA\Property(property="DeviceToken", type="string"),
     *     @OA\Property(property="DeviceType", type="integer", description="Device Type: 1 - IOS, 2 - Android, 3 - Website, 4 - Admin")
     * )
     * @OA\Post(
     *     path="/Login",
     *     operationId="Login",
     *     tags={"User"},
     *     summary="Login Process",
     *     description="DeviceType: 1 IOS, 2 Android, 3 Website, 4 Admin",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(ref="#/components/schemas/Login")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Login successfully."),
     *     @OA\Response(response=400, description="Something went wrong."),
     *     @OA\Response(response=404, description="Account with this email id could not be found."),
     *     @OA\Response(response=104, description="The Password you have entered is invalid.")
     * )
     */

    public function Login(Request $request)
    {
        $CheckEmail = User::where('Email', $request->Email)->where('IsDelete', 0)->first();
        if ($CheckEmail) {
            if ($request->SocialType != 0) {
                if ($request->SocialIdentifier != '') {
                    $GetSocialIdentifier = User::where('SocialIdentifier', $request->SocialIdentifier)->first();
                    if ($GetSocialIdentifier) {
                        if (Hash::check($request->Password, $GetSocialIdentifier->Password) == true) {
                            $UpdateAuthToken = User::where('UserId', $GetSocialIdentifier->UserId)->update([
                                'AuthToken'     => $this->GetnewToken(),
                                'DeviceToken'   => ($request->DeviceToken == '') ? '' : $request->DeviceToken,
                                'DeviceType'   => ($request->DeviceType == '') ? 0 : $request->DeviceType,
                                'SocialType'   => ($request->SocialType == '') ? 0 : $request->SocialType,
                                'updated_at'       => Carbon::now()->format('Y-m-d H:i:s'),
                            ]);
                            $GetData = User::where('UserId', $GetSocialIdentifier->UserId)->where('IsDelete', 0)->first();
                            $data = $this->UserResponse($GetData);
                            return $this->SuccessResponse(true, 200, 'User Login successfully.', $data);
                        } else {
                            return $this->ErrorResponse(false, 104, 'The Password you have entered is invalid.', new \stdClass());
                        }
                    } else {
                        return $this->ErrorResponse(false, 404, 'Our records indicated such user not registered yet.', new \stdClass());
                    }
                } else {
                    return $this->ErrorResponse(false, 101, 'Social Identifier is required.', new \stdClass());
                }
            } else {
                if (Hash::check($request->Password, $CheckEmail->Password) == true) {
                    $UpdateAuthToken = User::where('UserId', $CheckEmail->UserId)->update([
                        'AuthToken' => $this->GetnewToken(),
                        'DeviceToken'   => ($request->DevieceToken == '') ? '' : $request->DeviceToken,
                        'DeviceType'   => ($request->DeviceType == '') ? 0 : $request->DeviceType,
                        'SocialType'   => ($request->SocialType == '') ? 0 : $request->SocialType,
                        'updated_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                    ]);

                    $GetData = User::where('UserId', $CheckEmail->UserId)->where('IsDelete', 0)->first();
                    $data = $this->UserResponse($GetData);
                    return $this->SuccessResponse(true, 200, 'User Login successfully.', $data);
                } else {
                    return $this->ErrorResponse(false, 104, 'The Password you have entered is invalid.', new \stdClass());
                }
            }
        } else {
            return $this->ErrorResponse(false, 404, 'Account with this email id could not found.', new \stdClass());
        }
    }

    /**
     * @OA\Schema(
     *     schema="ChangePassword",
     *     @OA\Property(property="OldPassword", type="string"),
     *     @OA\Property(property="NewPassword", type="string")
     * )
     * @OA\Post(
     *     path="/ChangePassword",
     *     operationId="ChangePassword",
     *     tags={"User"},
     *     summary="Change Password Process",
     *     description="DeviceType: 1 IOS, 2 Android, 3 Website, 4 Admin",
     *     security={{"AuthToken":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(ref="#/components/schemas/ChangePassword")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Change password successfully."),
     *     @OA\Response(response=400, description="Something went wrong."),
     *     @OA\Response(response=401, description="Authentication token has expired."),
     *     @OA\Response(response=404, description="User not found."),
     *     @OA\Response(response=103, description="The old password you have entered is invalid.")
     * )
     */


    public function ChangePassword(Request $request)
    {
        $UserId = $this->validToken($request->header('AuthToken'));
        if ($UserId != false) {
            die($UserId);
            $GetUser = User::where('UserId', $UserId)->where('IsDelete', 0)->first();
            if (!empty($GetUser)) {
                if (Hash::check($request->OldPassword, $GetUser->Password) == false) {
                    return $this->ErrorResponse(false, 103, 'The old password you have entered is invalid.', new \stdClass());
                } else {
                    User::where('UserId', $UserId)->update([
                        'Password' => bcrypt($request->NewPassword),
                        'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
                    ]);
                    $data = $this->UserResponse($GetUser);
                    return $this->SuccessResponse(true, 200, 'Password change successfully.', $data);
                }
            } else {
                return $this->ErrorResponse(false, 404, 'User not found.', new \stdClass());
            }
        } else {
            return $this->ErrorResponse(false, 401, 'Authentication token has expired.', new \stdClass());
        }
    }

    /**
     * @OA\Schema(
     *     schema="ForgotPassword",
     *     @OA\Property(property="Email", type="string")
     * )
     * @OA\Post(
     *     path="/ForgotPassword",
     *     operationId="ForgotPassword",
     *     tags={"User"},
     *     summary="Forgot Password Process",
     *     description="DeviceType: 1 IOS, 2 Android, 3 Website, 4 Admin",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(ref="#/components/schemas/ForgotPassword")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Successfully."),
     *     @OA\Response(response=400, description="Something went wrong."),
     *     @OA\Response(response=401, description="Authentication token has expired."),
     *     @OA\Response(response=404, description="Account with this email id could not be found.")
     * )
     */

    public function ForgotPassword(Request $request)
    {
        $GetUser = User::where('Email', $request->Email)->where('IsDelete', 0)->first();

        if ($GetUser) {
            $FToken = rand(1, 1000000);
            $GetFToken = ForgotPasswordToken::where('UserId', $GetUser->UserId)->first();
            if ($GetFToken) {
                ForgotPasswordToken::where('UserId', $GetUser->UserId)->update([
                    'Token'   => $FToken,
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);
            } else {
                $TokenId = $this->GenerateUniqueRandomString($table = "forgot_password_tokens", $column = "TokenId", $chars = 32);
                // die($FToken);
                ForgotPasswordToken::create([
                    'TokenId' => $TokenId,
                    'UserId'  => $GetUser->UserId,
                    'Token'   => $FToken,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
            }
            $Response = [
                'ForgotToken' => $FToken,
            ];
            $username = $GetUser->FirstName . ' ' . $GetUser->LastName;
            $useremail = $GetUser->Email;
            // $body = array(
            //     'UserName' => $username,
            //     'ForgotToken' => $FToken
            // );

            Mail::to($useremail)->send(new ForgotPassword($username, $FToken));
            return $this->SuccessResponse(true, 200, 'Reset password code sent successfully.', $Response);
        } else {
            return $this->ErrorResponse(false, 404, 'Account with this email id could not found.', new \stdClass());
        }
    }

    /**
     * @OA\Schema(
     *     schema="ResetPassword",
     *     @OA\Property(property="UserId", type="string"),
     *     @OA\Property(property="Password", type="string")
     * )
     * @OA\Post(
     *     path="/ResetPassword",
     *     operationId="ResetPassword",
     *     tags={"User"},
     *     summary="Reset Password Process",
     *     description="DeviceType: 1 IOS, 2 Android, 3 Website, 4 Admin",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(ref="#/components/schemas/ResetPassword")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Reset password successfully."),
     *     @OA\Response(response=404, description="User not found.")
     * )
     */

    public function ResetPassword(Request $request)
    {
        $GetUser = User::where('UserId', $request->UserId)->first();
        if ($GetUser) {
            $UpdatePassword = User::where('UserId', $request->UserId)->update([
                'Password' => bcrypt($request->Password),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
            ForgotPasswordToken::where('UserId', $GetUser->UserId)->update([
                'Token' => 0,
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
            $data = $this->UserResponse($GetUser);
            return $this->SuccessResponse(true, 200, 'Password change successfully.', $data);
        } else {
            return $this->ErrorResponse(false, 404, 'User not found.', new \stdClass());
        }
    }
}
