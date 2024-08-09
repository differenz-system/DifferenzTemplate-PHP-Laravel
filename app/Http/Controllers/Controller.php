<?php

namespace App\Http\Controllers;

use App\JWT;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Differenz Template",
 *      description="L5 Swagger OpenApi description",
 * )
 * 
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Local URL Differenz_Template"
 * )
 * @OA\SecurityScheme(
 *      securityScheme="Authorization", 
 *      in="header",
 *      type="http", 
 *      name="Authorization",
 *      scheme="bearer",
 * ),
 */

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function GetnewToken()
    {
        error_reporting(0);
        $header  = '{"typ":"JWT","alg":"HS256"}';
        $payload = "DifferenzProject";
        $JWT     = new JWT;
        return $JWT->encode($header, $payload, date('Y-m-d H:i:s'));
    }
    // Validate Auth Token(Check Login) **********
    public static function validToken($Token)
    {
        if ($Token == "" || $Token == null) {
            return false;
        } else {
            $sql = User::where('AuthToken', $Token)->first();
            if ($sql) {
                return $sql->UserId;
            } else {
                return false;
            }
        }
    }
    // Genrate primary ID for each table **********
    public static function GenerateUniqueRandomString($table, $column, $chars)
    {
        $unique = false;
        do {
            $randomStr = Str::random($chars);
            $match = DB::table($table)->where($column, $randomStr)->first();
            if ($match) {
                continue;
            }
            $unique = true;
        } while (!$unique);
        return $randomStr;
    }
    // Generate API success reponse return **********
    public function SuccessResponse($flag, $statusCode, $message, $data)
    {
        return Response::json([
            'Flag' => $flag,
            'StatusCode' => $statusCode,
            'Message' => $message,
            'Data' => $data,
        ]);
    }
    // Generate API error reponse return **********
    public function ErrorResponse($flag, $statusCode, $message, $data)
    {
        return Response::json([
            'Flag' => $flag,
            'StatusCode' => $statusCode,
            'Message' => $message,
            'Data' => $data,
        ]);
    }
    // Upload image with specific path **********
    public function UploadImage($file, $path)
    {
        if ($file) {
            $ImageName = time() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $ImageName);
            return $ImageName;
        } else {
            return '';
        }
    }
    // Upload base 64 image with specific path **********
    public function UploadImageBase64($file, $path, $base64file)
    {
        if ($file) {
            list($type, $base64file) = explode(';', $base64file);
            list(, $base64file)      = explode(',', $base64file);
            $base64file = base64_decode($base64file);
            $ImageName = time() . '.' . $file->getClientOriginalExtension();
            file_put_contents($path . '/' . $ImageName, $base64file);
            return $ImageName;
        } else {
            return '';
        }
    }
    // User login & registration response return **********
    public function UserResponse($result)
    {
        $data = [
            'FirstName'         => ($result->FirstName != '') ? $result->FirstName : '',
            'LastName'          => ($result->LastName != '') ? $result->LastName : '',
            'Email'             => $result->Email,
            'AuthToken'         => $result->AuthToken,
            'ProfilePicture'    => $result->ProfilePicture,
            'ProfilePictureURL' => ($result->ProfilePicture != '') ? url('storage/web/images/profile') . '/' . $result->ProfilePicture : '',
            'DeviceToken'       => ($result->DeviceToken != '') ? $result->DeviceToken : '',
            'SocialType'        => ($result->SocialType != '' || $result->SocialType == 0) ? $result->SocialType : ''
        ];
        return $data;
    }
}
