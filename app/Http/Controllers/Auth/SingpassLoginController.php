<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\LoginController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
// use Firebase\JWT\JWK;
// use Firebase\JWT\JWT;
// use Firebase\JWT\Key;
use Jose\Component\Core\JWK;
use Jose\Easy\Build;
use Jose\Component\Core\AlgorithmManager;
use Jose\Component\Signature\Algorithm\HS256;
use Jose\Component\Core\Converter\StandardConverter;
use Jose\Component\Signature\Algorithm\ES256;
use Jose\Component\Signature\JWSBuilder;
use Jose\Component\Signature\Serializer\CompactSerializer;
use Jose\Component\KeyManagement\JWKFactory;
use Jose\Component\Signature\JWSVerifier;
use Jose\Component\Signature\Serializer\JWSSerializerManager;
use Jose\Component\Signature\Serializer;

use Jose\Component\Core\AlgorithmManagerFactory;
use Jose\Component\Core\JWKSet;
use Jose\Component\Encryption\Algorithm\ContentEncryption\A256CBCHS512;
use Jose\Component\Encryption\Algorithm\KeyEncryption\ECDHESA128KW;
use Jose\Component\Encryption\Algorithm\KeyEncryption\ECDHESA192KW;
use Jose\Component\Encryption\Algorithm\KeyEncryption\ECDHESA256KW;
use Jose\Component\Encryption\Algorithm\KeyEncryption\RSAOAEP256;
use Jose\Component\Encryption\Compression\CompressionMethodManager;
use Jose\Component\Encryption\Compression\Deflate;
use Jose\Component\Encryption\JWEDecrypter;
use Jose\Component\Encryption\Serializer\JWESerializerManager;
use Illuminate\Support\Facades\Cache;
use Jose\Component\Encryption\JWELoader;
use Jose\Easy\Load;
use Jose\Easy\Decrypt;
use Jose\Component\Checker\HeaderCheckerManager;
use Jose\Component\Checker\AlgorithmChecker;
use Jose\Component\Signature\JWSTokenSupport;
use Jose\Component\Encryption\Serializer\CompactSerializer as JWESerializer;
use Jose\Component\Signature\Serializer\CompactSerializer as JWSSerializer;

use GuzzleHttp;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class SingpassLoginController extends LoginController
{
    public function handleCallback(Request $request)
    {
        if (($request->get('code') !== null) && ($request->get('state') !== null)) {
            $authCode = $request->get('code');
            $state = $request->get('state');
            $clientID = "yTjVJDphlp9CHyAa3yULFmpkCHShIDQV";
            $kid = "hdqvArRlNsyb5n6-NrQdTivElkewclTvDbCPpVubIOk";

            $issuedAtTime = time();
            $expiredAtTime = time() + 110;

            // The algorithm manager with the HS256 algorithm.
            $algorithmManager = new AlgorithmManager([
                new ES256(),
            ]);

            // $jwk = JWKFactory::createECKey('P-256',['alg' => 'ES256', 'use' => 'sig']);
            // $key = new JWK([
            //     'kty' => 'EC',
            //     "use"   => "sig",
            //     "crv" => "P-256",
            //     "d" => "opQb7RjP_chuylKFlJN92JpkvPv_KLT8w2gkaAa0Qr4",
            //     "kid" => "sig-2021-06-17T02:01:04Z",
            //     "x"   => "7n290eay5LBAfQzLmP-eS4RqRs7DAowWDvOApcSEoig",
            //     "y"   => "SHnvF9nmi_kKpeYubzYWRQ4davH9REKWQBMQPcZt4xw",
            // ]);

            $key = new JWK([
                'kty' => 'EC',
                "use"   => "sig",
                "crv" => "P-256",
                "d" => "2o7wDsGhsIxZrHytYnUNZBI78tWCV4xl_In3RkXOZgw",
                "kid" => "IxG_6imsyXLRJzKpxGpW-653qDef1VARrwvEEHoBpXA",
                "x"   => "fOUDLyi_2CYLiHmKDd_eRPmvukTxQoZ9Oo9C4BO2w1A",
                "y"   => "rVlyX5C4EINNoQhmCuWN09fGjj3stuAmjUgWov0Jo4M",
            ]);

            // We instantiate our JWS Builder.
            $jwsBuilder = new JWSBuilder($algorithmManager);

            $payload = json_encode([
                "iss" => $clientID,
                "sub" => $clientID,
                "aud" => "https://id.singpass.gov.sg",
                "iat" => $issuedAtTime, // issued at time
                "exp" => $expiredAtTime // expiration time     
            ]);

            $jws = $jwsBuilder
                ->create()                               // We want to create a new JWS
                ->withPayload($payload)                  // We set the payload
                ->addSignature($key, ['alg' => 'ES256', 'typ' => 'JWT']) // We add a signature with a simple protected header
                ->build();
            $serializer = new CompactSerializer(); // The serializer
            $token = $serializer->serialize($jws, 0); // We serialize the signature at index 0 (we only have one signature).
            // dd($token);
            // echo $token;

            $redirectUri = "https://www.diycars.com/auth/callback";
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://id.singpass.gov.sg/token');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, "client_assertion_type=urn%3Aietf%3Aparams%3Aoauth%3Aclient-assertion-type%3Ajwt-bearer&client_assertion=".$token."&client_id=".$clientID."&grant_type=authorization_code&redirect_uri=https%3A%2F%2Fautolink.verz1.com/auth/callback&code=".$authCode);
            curl_setopt(
                $ch,
                CURLOPT_POSTFIELDS,
                "client_id=" . $clientID . "&redirect_uri=" . $redirectUri . "&grant_type=authorization_code&code=" . $authCode . "&client_assertion_type=urn:ietf:params:oauth:client-assertion-type:jwt-bearer&client_assertion=" . $token
            );

            $headers = array();
            $headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=ISO-8859-1';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            if ($result) {
                // dd($result);
                $tokenn = json_decode($result, true);
                // dd($tokenn);
                $token = $tokenn['id_token'];
                $tokenId = $this->getUserByToken($token);
                // $tokenId = $this->decryptJWENew($token);
                // $tokenParts = explode(".", $token);
                // $tokenHeader = base64_decode($tokenParts[0]);
                // $tokenPayload = base64_decode($tokenParts[3]);
                // dd($tokenId);
                if ($tokenId) {
                    $chkLogin = $this->loginUser($tokenId);
                }
                if ($chkLogin == true) {
                    return redirect('/home');
                }else{
                    return redirect('/register')->withErrors(['error' => 'Invalid Credential, You are not registered with us, please register']);;
                }
            }
        } else {
            echo 'Error';
        }
    }


    private function decryptJWENew($idToken)
    {
        $id_token = $idToken;
        $tokenParts = explode(".", $idToken);
        $tokenHeader = base64_decode($tokenParts[0]);
        $tokenHeader1 = base64_decode($tokenParts[2]);
        // $tokenPayload = base64_decode($tokenParts[3]);
        $decodeHeader = json_decode($tokenHeader, true);
        $deKid = $decodeHeader['kid'];
        $deX = $decodeHeader['epk']['x'];
        $deY = $decodeHeader['epk']['y'];
        $decryptionKey = new JWK([
            "kty" => "EC",
            "d" => "mg5EP7Df3bA5nLIK5Byw9Rf9g9L36-C76blg6aVN0s4",
            "use" => "enc",
            "crv" => "P-256",
            "kid" => "IxG_6imsyXLRJzKpxGpW-653qDef1VARrwvEEHoBpXA",
            "x"   => "f298ANKjTK0SNqW6Pgmq5faC7oNjxu52Oyn0O87Mhcw",
            "y"   => "oGg5U1qFKf1XKTmw1huprseR9r8ssp9e2JWpcSOysag",
        ]);

        $keyEncryptionAlgorithmManager = new AlgorithmManager([new ECDHESA128KW()]);
        $contentEncryptionAlgorithmManager = new AlgorithmManager([new A256CBCHS512()]);
        $compressionMethodManager = new CompressionMethodManager([new Deflate(),]);


        $decrypter = new JWEDecrypter(
            new AlgorithmManager([new ECDHESA128KW()]),
            new AlgorithmManager([new A256CBCHS512()]),
            new CompressionMethodManager([new Deflate(),])
        );


        $jweSerializer = new JWESerializer();
        $jwe = $jweSerializer->unserialize($id_token);
        // dd($jwe->getPayload());
        $decryptCon = $decrypter->decryptUsingKey($jwe, $decryptionKey, 0);
        $payloadData = $jwe->getPayload();
        $tokenParts = explode(".", $payloadData);
        $payloadData0 = base64_decode($tokenParts[0]);
        $payloadData1 = base64_decode($tokenParts[1]);
        // $payloadData2 = base64_decode($tokenParts[2]);
        // $tokenPayload = base64_decode($tokenParts[3]);
        // dd($jwe->getPayload());
        // $payloadData1 = json_decode($payloadData1, true);
        // dd($payloadData1);
        // $signatureAlgorithmManager = new AlgorithmManager([new ES256()]);
        // $jwsVerifier = new JWSVerifier($signatureAlgorithmManager);

        // $jwsSerializer = new JWSSerializer();
        // $jws = $jwsSerializer->unserialize($jwe->getPayload());
        // if (!$jwsVerifier->verifyWithKey($jws, $verificationKey, 0)) {
        //     dd('Invalid signature');
        // }

        if ($payloadData1) {
            return $payloadData1;
        }
    }

    protected function getUserByToken($token)
    {

        $jwe = $token;
        info("Encrypted JWE: $jwe");
        // decrypt the JWE
        $content = $this->decryptJWE($jwe);
        info("Decrypted JWE: $content");
        if (!is_null($content)) {
            // verify the content of JWT
            $jws = $this->verifyTokenSignature($content);
            if (!$jws) {
                // abort if signature check failed

                return redirect('singpass/error');
                // abort(Response::HTTP_UNAUTHORIZED, "Singpass Signature checking failed");
            }
            return $jws;
        } else {
            return redirect('singpass/error');
            // abort(Response::HTTP_BAD_REQUEST, "Unable to decrypt JWE");
        }
    }

    private function decryptJWE($idToken)
    {
        info($idToken);
        $config = $this->getOpenIDConfiguration();
        $keyEncryptionsAlgo = new AlgorithmManagerFactory();
        // create algorithm alias for token encryption that might used by singpass

        $keyEncryptionsAlgo->add('ECDH-ES+A256KW', new ECDHESA256KW());
        $keyEncryptionsAlgo->add('ECDH-ES+A192KW', new ECDHESA192KW());
        $keyEncryptionsAlgo->add('ECDH-ES+A128KW', new ECDHESA128KW());
        $keyEncryptionsAlgo->add('RSA-OAEP-256', new RSAOAEP256());
        $keyEncryptionsAlgo->create($config['id_token_encryption_alg_values_supported'] ?? []);

        // create algorithm alias for content encryption that used by singpass based on openid configuration
        $contentEncryptionAlgo = new AlgorithmManagerFactory();
        $contentEncryptionAlgo->add('A256CBC-HS512', new A256CBCHS512());

        $contentEncryptionAlgo->create($config['id_token_encryption_enc_values_supported'] ?? []);

        $compressionMethodManager = new CompressionMethodManager([
            new Deflate()
        ]);
        $keyEncryptionAlgorithmManager = new AlgorithmManager($keyEncryptionsAlgo->all());
        $contentEncryptionAlgorithmManager = new AlgorithmManager($contentEncryptionAlgo->all());
        // create a JWE decrypter
        $decrypter = new JWEDecrypter(
            $keyEncryptionAlgorithmManager,
            $contentEncryptionAlgorithmManager,
            $compressionMethodManager
        );

        $jwk = new JWK([
            "kty" => "EC",
            "d" => "mg5EP7Df3bA5nLIK5Byw9Rf9g9L36-C76blg6aVN0s4",
            "use" => "enc",
            "crv" => "P-256",
            "kid" => "IxG_6imsyXLRJzKpxGpW-653qDef1VARrwvEEHoBpXA",
            "x"   => "f298ANKjTK0SNqW6Pgmq5faC7oNjxu52Oyn0O87Mhcw",
            "y"   => "oGg5U1qFKf1XKTmw1huprseR9r8ssp9e2JWpcSOysag",
        ]);


        $serializerManager = new JWESerializerManager([new \Jose\Component\Encryption\Serializer\CompactSerializer()]);
        $jwe = $serializerManager->unserialize($idToken);

        // if decryption is success return the decrypted payload
        if ($decrypter->decryptUsingKey($jwe, $jwk, 0)) {
            info("user: " . $jwe->getPayload());
            return $jwe->getPayload();
        }
        return null;
    }


    public function verifyTokenSignature($token)
    {

        $config = $this->getOpenIDConfiguration();
        // load Singpass JWKS
        $singpassJWKS  = $this->retrieveSingPassVerificationKey();
        $jwks = JWKSet::createFromJson($singpassJWKS);
        // select Signature key
        $verificationKey = $jwks->selectKey('sig');

        $signatureAlgo = new AlgorithmManagerFactory();
        $signatureAlgo->add('ES256', new ES256());
        $signatureAlgo->create($config['id_token_signing_alg_values_supported'] ?? []);

        $signatureAlgoManager =  new AlgorithmManager($signatureAlgo->all());
        $serializerManager = new JWSSerializerManager([
            new CompactSerializer()
        ]);

        $jwsVerifier = new JWSVerifier($signatureAlgoManager);

        $jws = $serializerManager->unserialize($token);
        $isVerified = $jwsVerifier->verifyWithKey($jws, $verificationKey, 0);
        return   $isVerified ? json_decode($jws->getPayload()) : false;
    }

    public function retrieveSingPassVerificationKey(): string
    {
        $config = $this->getOpenIDConfiguration();
        try {
            $client = new GuzzleHttp\Client();
            $response = $client->request('GET', $config['jwks_uri'], [
                'headers' => ['Accept' => 'application/json']
            ]);

            return $response->getBody()->getContents();
        } catch (ServerException $e) {
            $errorResponse = $e->getResponse()->getBody()->getContents();
            $errorResponse = json_decode($errorResponse, true);
            Log::error('Unable to retrieve Singpass JWKS', $errorResponse);
            abort(Response::HTTP_BAD_GATEWAY, "Unable to login using Singpass right now");
        }
    }

    public function getOpenIDConfiguration()
    {
        if (Cache::has('singpassOpenIDConfig')) {
            return Cache::get('singpassOpenIDConfig');
        }
        // $response = $this->getHttpClient()->get(config("https://id.singpass.gov.sg/.well-known/openid-configuration"), [
        //     'headers' => ['Accept' => 'application/json']
        // ]);

        $client = new GuzzleHttp\Client();
        $response = $client->request('GET', 'https://id.singpass.gov.sg/.well-known/openid-configuration', [
            'headers' => ['Accept' => 'application/json']
        ]);

        $openIDConfig = json_decode($response->getBody(), true);

        Cache::put('singpassOpenIDConfig', $openIDConfig, now()->addHour());

        return $openIDConfig;
    }

    public function loginUser($token)
    {
        $subb = $token->sub;
        $exSub = explode(',', $subb);
        $subFirst = $exSub[0];
        $exSubFirst = explode('=', $subFirst);
        $clientId = $exSubFirst[1];
        $chkUser = User::where('singpass_id', $clientId)->where('status', 1)->first();
        Session::put('singpass_id', $clientId);
        if ($chkUser) {
            if (empty($chkUser->email)) {
                // if (Auth::attempt(['singpass_id' => $clientId, 'password' => $clientId])) {
                //     return true;
                // } else {
                //     return redirect()->back()->withError('error', 'Invalid login');
                //     return false;
                // }
                return false;
            } else {
                $user = User::findOrFail($chkUser->id);
                // Auth::login($user);
                if(Auth::loginUsingId($user->id)){
                    return true;
                }
            }
        } else {
            return false;
            // $user = new User();
            // $user->singpass_id = $clientId;
            // $user->email = $clientId . '@gmail.com';
            // $user->name = $clientId;
            // $user->status = 1;
            // $user->social_login_type = 3;
            // $user->password = Hash::make($clientId);
            // $user->save();
            // if (Auth::attempt(['singpass_id' => $clientId, 'password' => $clientId])) {
            //     return true;
            // } else {
            //     return redirect()->back()->withError('error', 'Invalid login');
            //     return false;
            // }
        }
    }

    public function showError(){
        return view('errors.singpass_error');
    }
}
