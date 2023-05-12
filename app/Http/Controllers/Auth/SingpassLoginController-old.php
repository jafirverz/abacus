<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;

class SingpassLoginController extends LoginController
{
    public function handleCallback(Request $request){
        if(($request->get('code') !== null) && ($request->get('state') !== null)){
            $authCode = $request->get('code');
            $state = $request->get('state');
            $clientID = "aOcNhgD9UtTA9iPKSn8x840olDi68SPo";
            $kid = "hdqvArRlNsyb5n6-NrQdTivElkewclTvDbCPpVubIOk";

            

            // Create token header as a JSON string
            $header = json_encode(['typ' => 'JWT', 'alg' => 'ES256', 'kid' => $kid]); //, 'kid' => 'rp_Key_'.time()

            $privateKey = "-----BEGIN EC PRIVATE KEY-----MHcCAQEEIAtq5c2TPw6xwzuLsigyDGVc/5p6xUsPr/BSMdMhTGT7oAoGCCqGSM49AwEHoUQDQgAECANJ41Vg85T5nRluWtTndUfU5a5/O7fBaHt9dcdbHuVYTKZSI4DP5J7hTsF7anK41X5VyNGS106oOCedfBSscg==-----END EC PRIVATE KEY-----";
            $formamattedprivateKey = str_replace(['-----BEGIN EC PRIVATE KEY-----', '-----END EC PRIVATE KEY-----', ' '], ['', '', ''], $privateKey);

            // Create token payload as a JSON string
            $issuedAtTime = time();
            $expiredAtTime = time() + 110;
            $payload = json_encode(
                        [
                            'iss' => $clientID,
                            "sub" => $clientID,
                            "aud" => "https://stg-id.singpass.gov.sg", 
                            "iat" => $issuedAtTime, // issued at time
                            "exp" => $expiredAtTime // expiration time     
                        ]);

            // Encode Header to Base64Url String
            $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

            // Encode Payload to Base64Url String
            $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

            // Create Signature Hash
            $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $formamattedprivateKey, true);

            // Encode Signature to Base64Url String
            $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

            // Create JWT
            $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
            //$jwt = "eyJ0eXAiOiJKV1QiLCJraWQiOiJycF9LZXlfMTYzNDc4NTIxNiIsImFsZyI6IkVTMjU2In0.eyJpc3MiOiJhT2NOaGdEOVV0VEE5aVBLU244eDg0MG9sRGk2OFNQbyIsInN1YiI6ImFPY05oZ0Q5VXRUQTlpUEtTbjh4ODQwb2xEaTY4U1BvIiwiYXVkIjoiaHR0cHM6Ly9zdGctaWQuc2luZ3Bhc3MuZ292LnNnIiwiaWF0IjoxNjM0Nzg1MjE2LCJleHAiOjE2MzQ3ODUzMjZ9.nrvJTQ6wyiF-9jfL3ZtV3MFf-2s8pZCubcm_gseqbRgPkuttsQi7rGXrzDp2ALENvKw7wAcKa5RffGMG4AdVog";
            echo '</br><pre>';
            print_r(['header' => $header, 'payload' => $payload, 'privateKey' => $privateKey, 'formamattedprivateKey' => $formamattedprivateKey]);
            echo "</pre>";

            echo '</br><pre>';
            print_r(['authCode' => $authCode, 'state' => $state, 'jwt' => $jwt]);
            echo "</pre>";

            // CURL Request for granting auth code using client assertion
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://stg-id.singpass.gov.sg/token');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "client_assertion_type=urn%3Aietf%3Aparams%3Aoauth%3Aclient-assertion-type%3Ajwt-bearer&client_assertion=".$jwt."&client_id=".$clientID."&grant_type=authorization_code&redirect_uri=https%3A%2F%2Fautolink.verz1.com/auth/callback&code=".$authCode);

            $headers = array();
            $headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=ISO-8859-1';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            if($result){
                echo '</br><pre>';
                print_r($result);
                echo '</pre>';
            }
        }else{
            echo 'Error';
        }
    }
}