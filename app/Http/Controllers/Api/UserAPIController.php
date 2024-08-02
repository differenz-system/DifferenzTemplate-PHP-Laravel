<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
}
