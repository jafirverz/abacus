<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
use Jose\Component\Encryption\Algorithm\ContentEncryption\A256GCM;
use Jose\Component\Encryption\Algorithm\KeyEncryption\ECDHESA128KW;
use Jose\Component\Encryption\Algorithm\KeyEncryption\ECDHESA192KW;
use Jose\Component\Encryption\Algorithm\KeyEncryption\ECDHESA256KW;
use Jose\Component\Encryption\Algorithm\KeyEncryption\RSAOAEP256;
use Jose\Component\Encryption\Algorithm\KeyEncryption\RSAOAEP;
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
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Support\Facades\Log;
use Jose\Loader;
use Illuminate\Support\Facades\Session;

class MyinfoController extends Controller
{



  public function authorise(Request $request)
  {

    $code = $request->code;
    $state = $request->state;
    $headers = [
      'Cache-Control' => 'no-cache',
      'Accept' => 'application/json',
      'Content-Type'  => 'application/x-www-form-urlencoded',
    ];

    $params = [
      'grant_type'    => 'authorization_code',
      'redirect_uri'  => config('myinfo.call_back_url'),
      'client_id'     => config('myinfo.client_id'),
      'client_secret' => config('myinfo.client_secret'),
      'code'          => $code,
      'state'          => $state,
    ];

    $method = 'POST';

    $authHeaders = $this->generateSHA256withRSAHeader(
      config('myinfo.api.token'),
      $params,
      $method,
      $headers['Content-Type'],
      config('myinfo.client_id'),
      config('myinfo.client_secret')
    );

    $headers['Authorization'] = $authHeaders;
    // print_r($params);
    // dd($headers);
    $http = new Client;
    // $client = new GuzzleHttp\Client();

    // $response = $client->request('POST', config('myinfo.api.token'), [
    //   'form_params' => $params,
    //   'headers' => $headers,
    // ]);

    $response = $http->post(config('myinfo.api.token'), [
      'form_params' => $params,
      'headers' => $headers,
    ]);
    // dd($response->getBody()->getContents());
    $data = $response->getBody()->getContents();
    $result = json_decode($data);
    $jwtAccessToken = $result->access_token;
    // $this->createPersonRequest($uen, $userUniFin, $jwtAccessToken);
    $data = $this->getJWTPayload($jwtAccessToken);
    $sub = $data['sub'];
    $details = $this->createPersonRequest($sub, $jwtAccessToken);
    $userDetails = array();
    // dd($details);
    $userDetails['uinfin'] = $details['uinfin']['value'];
    $userDetails['name'] = $details['name']['value'];
    $userDetails['sex'] = $details['sex']['desc'];
    $userDetails['nationality'] = $details['nationality']['code'];
    $userDetails['dob'] = $details['dob']['value'];
    $userDetails['email'] = $details['email']['value'];
    $userDetails['mobileno'] = $details['mobileno']['nbr']['value'] ?? '';
    $userDetails['areacode'] = $details['mobileno']['areacode']['value'] ?? '';
    $userDetails['prefix'] = $details['mobileno']['prefix']['value'] ?? '';
    $userDetails['countryCode'] = $userDetails['prefix'] . $userDetails['areacode'] ?? '';
    $userDetails['marital'] = $details['marital']['desc'] ?? '';
    $userDetails['occupation'] = $details['occupation']['value'] ?? '';
    $userDetails['employment'] = $details['employment']['value'] ?? '';
    
    $userDetails['meritstatus'] = $details['drivinglicence']['comstatus']['desc'] ?? '';
    $userDetails['validity'] = ucwords(strtolower($details['drivinglicence']['qdl']['validity']['desc'])) ?? '';
    $classsss = $details['drivinglicence']['qdl']['classes'];
    if(sizeof($classsss) > 0){
        $counttt = count($classsss);
        $userDetails['classsvalue'] = $details['drivinglicence']['qdl']['classes'][$counttt - 1]['class']['value'] ?? '';
        $userDetails['classsvalidity'] = date('d-m-Y', strtotime($details['drivinglicence']['qdl']['classes'][$counttt - 1]['issuedate']['value'])) ?? '';
        $userDetails['drivinglicenseclass'] = $userDetails['classsvalue'] . ', '. $userDetails['classsvalidity']; 
    }else{
        $userDetails['classsvalue'] = '';
        $userDetails['classsvalidity'] = '';
        $userDetails['drivinglicenseclass'] = ''; 
    }
    
    $userDetails['unit'] = $details['regadd']['unit']['value'] ?? '';
    $userDetails['street'] = $details['regadd']['street']['value'] ?? '';
    $userDetails['block'] = $details['regadd']['block']['value'] ?? '';
    $userDetails['postal'] = $details['regadd']['postal']['value'] ?? '';
    $userDetails['floor'] = $details['regadd']['floor']['value'] ?? '';
    $userDetails['building'] = $details['regadd']['building']['value'] ?? '';
    // $userDetails['address'] = $userDetails['unit'] . ' '. $userDetails['street'] . ', '. $userDetails['block'] . ' '. $userDetails['floor'] . ' '.$userDetails['building']. ', '.  $userDetails['postal'] ;
    $userDetails['address'] = $userDetails['block'] . ' '. $userDetails['street'] . ', '.$userDetails['floor'].'-'.$userDetails['unit'].', '.$userDetails['postal'];
    if(sizeof($details['vehicles']) > 0){
      $userDetails['vehiclesNo'] = $details['vehicles'][0]['vehicleno']['value'] ?? '';
      $userDetails['type'] = $details['vehicles'][0]['type']['value'] ?? '';
      $userDetails['make'] = $details['vehicles'][0]['make']['value'] ?? '';
      $userDetails['model'] = $details['vehicles'][0]['model']['value'] ?? '';
      $userDetails['yearofmanufacture'] = $details['vehicles'][0]['yearofmanufacture']['value'] ?? '';
      $userDetails['originalregistrationdate'] = $details['vehicles'][0]['originalregistrationdate']['value'] ?? '';
      $userDetails['make_model'] = $userDetails['make'] . ' '. $userDetails['model'] ?? '';
      $userDetails['enginecapacity'] = $details['vehicles'][0]['enginecapacity']['value'] ?? '';
      $userDetails['chassisno'] = $details['vehicles'][0]['chassisno']['value'] ?? '';
      $userDetails['primarycolour'] = $details['vehicles'][0]['primarycolour']['value'] ?? '';
      $userDetails['scheme'] = $details['vehicles'][0]['scheme']['value'] ?? '';
      $userDetails['propellant'] = $details['vehicles'][0]['propellant']['value'] ?? '';
      $userDetails['engineno'] = $details['vehicles'][0]['engineno']['value'] ?? '';
    }
    
    if(!Session::get('myinfodetails')){
      Session::put('myinfodetails', $userDetails);
    }else{
      Session::forget('myinfodetails');
      Session::put('myinfodetails', $userDetails);
    }
    Session::forget('myinfoinsurancebusiness');
    // dd($userDetails);
    // return redirect()->back();
    return redirect('/insurance');
    // dd($details);
    // dd($response->getBody()->getContents());
    // dd($response);
    // return $response->getBody();
  }

  private function generateSHA256withRSAHeader(
    $url,
    $params,
    $method,
    $strContentType,
    $appId,
    $passphrase
  ) {
    $nonceValue = $this->generateNonce(32);
    // $nonceValue = rand(10000000000, 99999999999);
    $timestamp = round(microtime(true) * 1000);
    $defaultApexHeaders = [
      'app_id'           => $appId,
      'nonce'            => $nonceValue,
      'signature_method' => 'RS256',
      'timestamp'        => $timestamp,
    ];

    if ($method == 'POST' && $strContentType != 'application/x-www-form-urlencoded') {
      $params = [];
    }

    $baseParams = array_merge($defaultApexHeaders, $params);
    ksort($baseParams);

    $baseParamsStr = urldecode(http_build_query($baseParams));

    $baseString = strtoupper($method) . '&' . $url . '&' . $baseParamsStr;

    $privateKey = \File::get(storage_path('ssl/private.pem'));

    // $signWith = $privateKey;
    $signWith[] = $privateKey;
    if (isset($passphrase) && !empty($passphrase)) {
      $signWith[] = $passphrase;
    }
    // dd($signWith);

    openssl_sign($baseString, $signature, $signWith, 'sha256WithRSAEncryption');
    return 'PKI_SIGN app_id="' . $appId .
      '",nonce="' . $nonceValue .
      '",timestamp="' . $timestamp .
      '",signature_method="RS256"' .
      ',signature="' . base64_encode($signature) .
      '"';
  }

  private function generateNonce($length = 9, $strength = 0)
  {
    $vowels = 'aeuy';
    $consonants = 'bdghjmnpqrstvz';
    if ($strength & 1) {
      $consonants .= 'BDGHJLMNPQRSTVWXZ';
    }
    if ($strength & 2) {
      $vowels .= "AEUY";
    }
    if ($strength & 4) {
      $consonants .= '23456789';
    }
    if ($strength & 8) {
      $consonants .= '@#$%';
    }
    $password = '';
    $alt = time() % 2;
    for ($i = 0; $i < $length; $i++) {
      if ($alt == 1) {
        $password .= $consonants[(rand() % strlen($consonants))];
        $alt = 0;
      } else {
        $password .= $vowels[(rand() % strlen($vowels))];
        $alt = 1;
      }
    }
    return $password;
  }

  public function createPersonRequest($userUniFin, $jwtAccessToken)
  {
    $url            = config('myinfo.api.personal') . '/' . $userUniFin . '/';

    $params = [
      'attributes' => config('myinfo.attributes'),
      'client_id' => config('myinfo.client_id')
    ];

    $headers = [
      'Cache-Control' => 'no-cache',
    ];

    $authHeaders    = $this->generateSHA256withRSAHeader(
      $url,
      $params,
      'GET',
      '',
      config('myinfo.client_id'),
      config('myinfo.client_secret')
    );

    if (!empty($authHeaders)) {
      $headers['Authorization'] = $authHeaders . ",Bearer " . $jwtAccessToken;
    } else {
      $headers['Authorization'] = "Bearer " . $jwtAccessToken;
    }

    $http = new Client;

    $response = $http->get($url, [
      'query' => $params,
      'headers' => $headers,
    ]);
    // dd($response->getBody()->getContents());
    // return $response->getBody()->getContents();
    $encryptedUserData = $response->getBody()->getContents();
    $privateKeyPath = storage_path('ssl/private.pem');
    return $this->getUserData($encryptedUserData, $privateKeyPath);
  }

  public function getUserData($encryptedUserData, $privateKeyPath)
  {
    $key = JWKFactory::createFromKeyFile(
      $privateKeyPath,
      config('myinfo.client_secret'),
      [
        'kid' => '-----BEGIN RSA PRIVATE KEY-----
MIIEowIBAAKCAQEAsmxhdKSxTXG/FDwlQEk7PTDhXP9AY0kQK0AFxnCBbY/vLUlx
yr4l9DD7UqfHjf+SKIMWRAK5hx+WuhdXtLL5VdtmWY/zJzyhJ8FtMUOr9BmiIHGV
cybadiXwaTQ16MBcUj9QCYNGhAjsFNs23AlxXTT1TbqEzYO9vuXke/gur5QUO9ls
ZQmP1FWMENEI4tQW1CyeSQnm+X7cxmqsIpf4S6zoZYi0yuNOFmdsjp/rGlCP+bGL
jd7/hGm7iK01QecyJl+Y6Z4kdHdro9bI+xt27tvKLMBcxDZS2s5RBXH03U9cE6BV
JL/9DWLXkT+L6K34kbT49ga5t29EWE88VZyytwIDAQABAoIBAQCoCBnf2BqCbNUf
IWWTnWQExLv48QqadnybvrexotLBdAQ0Ci74WQs1ZcvKk+gDeuUS8iFN+6Lt9nnk
14bpzoOyr+U8A61jDl5XKnrDIpAWWu2s0EuHHtgu3JwE9/6tLDvF2Ypu6wrF3gE3
wxtvLhVtSiqbAUWApslTtv3vIlQVVTK7bUexfT1Pb2hUc6FoZ72sxQy3LGLij4qQ
NI7hchVn9lFZfVPWEwV2JKqozbgCPPvFYydZ8NmkhHuaklS979bkvo8M9vdjCJA0
TwgcDIwkRPag8YrRmbQTZ+2LnwMcYFltEbwsZDSyHTjnPHdEaoJLY9/QokyP9ULp
73FkgMSBAoGBAO3lf59z77tjZ6TYq6y3EfDfHNLU0c7Egfm4FfXNW/inxCswQi47
iqPYL6W/M6YmHwr6773bvagv8pRjGVoinKiaE4mE+qZOmJN4BUkaaS7jHCUeVe0z
302rI89xccXZ5HeNQfIKjWwJ3u629df52TYZ9Yk4hPchgmSzsPCQHtUfAoGBAMAA
Rr23YHJE4Igi9ZYwkKYFgjvTBA50r/uUH/TbOED3pTVDBLQSWqQqdzesUI8VONxr
kM6akfJEpTWNPz6RYqyAwqMjcasZ9VQWDdbm0NdjpLjXbqrhYpPIHwmtKsL1VX/T
73RD5+b2XgDKq4eqEgToNaarz+Hmc2HJX9VcfpdpAoGASd+NXPeEhz0cDy2VSeHj
eVffPH0H1dxhvCj08Mpfd/yoxvyKYI7uw2g7i42vPTXzR9aaoetdnp+dBYUsdzfu
S9DkpjycFQ6tBIYtpgDEjuHJeKFN74W/HwA484731IeQEavUwZOTTOxXxOsdtn6I
e+tdusnJSHCobBr8pAcs++MCgYAdPO2I3m/1dr+qe4higqrEXXpjmdK4UNSrvvbO
1sNOQWgLIFWLBnB/J2hYNglegKDUEB1RGQC4n/N4oDXNVV5tXn5FUZRxtdZCI8mf
vC55XlcrPsM/imr0jjkLxC8K2UlX2fJRBjY+Wa4e+L3+PsvXq3TgGLHjeLCBZ6UM
XLV6YQKBgDA9HESWQsWXI6g9AVDBefeG//tI+rPRZJGqscFA5e+JRDUIaeKgTIOC
MssPkqFR9f6sWPng7knBNRl5wPGFtlTHbekdWmtEIWAutHenhjxAohg7icbPHSI9
6VquRRw34Zj+2aMueRS/Jq09JlhpRMNSFXItrqu50oGjVMN9SGj2
-----END RSA PRIVATE KEY-----',
        'use' => 'enc',
        'alg' => 'RSA-OAEP',
      ]
    );

    $keyEncryptionsAlgo = new AlgorithmManagerFactory();
    $keyEncryptionsAlgo->add('ECDH-ES+A256KW', new ECDHESA256KW());
    $keyEncryptionsAlgo->add('ECDH-ES+A192KW', new ECDHESA192KW());
    $keyEncryptionsAlgo->add('ECDH-ES+A128KW', new ECDHESA128KW());
    $keyEncryptionsAlgo->add('RSA-OAEP', new RSAOAEP());
    $keyEncryptionsAlgo->add('RSA-OAEP-256', new RSAOAEP256());

    $contentEncryptionAlgo = new AlgorithmManagerFactory();
    $contentEncryptionAlgo->add('A256GCM', new A256GCM());
    $contentEncryptionAlgo->add('A256CBC-HS512', new A256CBCHS512());

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

    $serializerManager = new JWESerializerManager([new \Jose\Component\Encryption\Serializer\CompactSerializer()]);
    $jwe = $serializerManager->unserialize($encryptedUserData);
    if ($decrypter->decryptUsingKey($jwe, $key, 0)) {
      info("user: " . $jwe->getPayload());
      // dd($jwe->getPayload());
      // dd($this->getJWTPayloadPerson($jwe->getPayload()));
      return $this->getJWTPayloadPerson($jwe->getPayload());
      // return redirect('/insurance');
      
    }
    

    // $loader = new Loader();
    // $userData = $loader->loadAndDecryptUsingKey(
    //   $encryptedUserData, // String to load and decrypt
    //   $key,               // The symmetric or private key
    //   ['RSA-OAEP'],       // A list of allowed key encryption algorithms
    //   ['A256GCM'],        // A list of allowed content encryption algorithms
    //   $recipient_index    // If decrypted, this variable will be set with the recipient index used to decrypt
    // );
    // return $this->getJWTPayload($userData->getPayload());
  }

  public function getJWTPayload($jwtAccessToken)
  {
    list($header, $payload, $signature) = explode(".", $jwtAccessToken);
    // dd(json_decode(base64_decode($header), true));
    // dd(json_decode(base64_decode($payload), true));
    return json_decode(base64_decode($payload), true);
    
    
    // return json_decode(base64_decode($payload), true);
  }

  public function getJWTPayloadPerson($jwtAccessToken)
  {
    list($header, $payload, $signature) = explode(".", $jwtAccessToken);

    return json_decode(base64_decode($payload), true);
  }
}
