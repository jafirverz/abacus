<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DocuSign\eSign\Configuration;
use DocuSign\eSign\Api\EnvelopesApi;
use DocuSign\eSign\Client\ApiClient;
use Exception;
use Session;
use App\Insurance;
use App\User;
use App\Admin;

class DocusignInsuranceController extends Controller
{

    /** hold config value */
    private $config;

    private $signer_client_id = 1000; # Used to indicate that the signer will use embedded

    /** Specific template arguments */
    private $args;


    /**
     * Show the html page
     *
     * @return render
     */
    public function index()
    {
         return view('docusign.connect');
        
    }


    public function seller($id = null)
    {
        // return view('docusign.connect');
       
        $success = '';
        try {
            $this->args = $this->getTemplateArgs();

            $args = $this->args;


            $envelope_args = $args["envelope_args"];
            
            # Create the envelope request object
            $envelope_definition = $this->make_envelope($args["envelope_args"], $id);
            // dd($envelope_definition);
            $envelope_api = $this->getEnvelopeApi();
            
            # Call Envelopes::create API method
            # Exceptions will be caught by the calling function
            $api_client = new \DocuSign\eSign\client\ApiClient($this->config);
            $envelope_api = new \DocuSign\eSign\Api\EnvelopesApi($api_client);
            $results = $envelope_api->createEnvelope($args['account_id'], $envelope_definition);
            // dd($results->getStatus());
            $envelope_id = $results->getEnvelopeId();
            if($results->getStatus() == 'sent' && !empty($envelope_id)){
                $success = 1;
                // $buyerParticular = BuyerParticular::where('seller_particular_id', $id)->first();
                // $buyerParticular->docu_sent = 1;
                // $buyerParticular->save();
            }else{
                $success = 0;
                return redirect()->back()->with('error', 'Please connect docusign');
            }

            $authentication_method = 'None'; # How is this application authenticating
            # the signer? See the `authenticationMethod' definition
            # https://developers.docusign.com/esign-rest-api/reference/Envelopes/EnvelopeViews/createRecipient
            $recipient_view_request = new \DocuSign\eSign\Model\RecipientViewRequest([
                'authentication_method' => $authentication_method,
                'client_user_id' => $envelope_args['signer_client_id'],
                'recipient_id' => '1',
                'return_url' => $envelope_args['ds_return_url'],
                'user_name' => 'Diy Cars', 'email' => 'info@diycars.com'
            ]);
            // dd("hello");
            // $results = $envelope_api->createRecipientView($args['account_id'], $envelope_id, $recipient_view_request);
            return redirect()->back()->with('success', 'PDF sent');
            // return redirect()->to($results['url']);
        } catch (Exception $e) {
            // dd($e);
            if($success == 1){
                return redirect()->back()->with('success', 'PDF sent');
            }
            return redirect()->back();
            
        }
    }


    /**
     * Connect your application to docusign
     *
     * @return url
     */
    public function connectDocusign()
    {
        
        try {
            $params = [
                'response_type' => 'code',
                'scope' => 'signature impersonation',
                'client_id' => env('DOCUSIGN_CLIENT_ID_INSURANCE'),
                // 'state' => 'a39fh23hnf23',
                'redirect_uri' => "https://diycars.com/admin/insurance/callback",
            ];
            $queryBuild = http_build_query($params);
            $url = "https://account-d.docusign.com/oauth/auth?";

            $botUrl = $url . $queryBuild;
            return redirect()->to($botUrl);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something Went wrong !');
        }
    }

    function base64url_encode($data) { 
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
    }

    /**
     * This function called when you auth your application with docusign
     *
     * @return url
     */
    public function callback(Request $request)
    {
        // $code = $request->code;
        $jwtHeader = $this->base64url_encode(json_encode(array(
            "alg" => "RS256",
            "typ" => "JWT"
        )));
        
        
        $issuedAtTime = time();
        $expiredAtTime = time() + 360;
        $userId = "6bd3297d-043a-4d14-92fd-bdeef86498f5";
        $clientId = "1054db12-1355-49fc-914c-299f371ba64d";
        $private_key = "-----BEGIN RSA PRIVATE KEY-----
MIIEpAIBAAKCAQEAltbV/1RPLaKyXowawZJgyb7crkAk1h6v7CWOu5hKKpKi6P9n
lH+ZlsZ/OEo5MWSsSWskS8bNfZSqhv4BhOv2mEmkenrEbnVJbziBAB4LvL7YRJPv
/7Rf/zIpchOFcvdEcxJgBH38WoFGquCkfpFHny+q/wQO39+f8LaA6wKP8aj6Y9i3
VDRHHwHYRXYtJvvpPWajNEt8oICvIq9ZeCPY21vnjmxY0aWyREoaBHx17Nu75Xwj
B+9vmmyMg9RSCosOyGTYyutzTCvv7jxneT9ndsyHU78r17u5y0ewD6P+fX/zFUSf
0l6iRqud8UZMx59SAIQGfoTdj8aq0L6YcH63DQIDAQABAoIBAAHSja+x5+pVaBH5
X7dir+BazyrHI/V3AHQkzgaD5Agt+7bp+Gk/E27Sw3sSy9cbcB4g+RrLR59SpQQl
hy+BHwUfBVQ6LdZnJ2B8eR6JvmWPlBMGteR2hvRmjuv4bWktW0/dSHi1bE+hoTtz
pGPSbeBFVgESc6WOe6MPvsYCzWoY4Prb1XCGLAXJL1B5tmSlsYc34hRDc1M8naxX
5gZszGzluS3cBefZhzUZP/qv2G88O9uRy2OPgKkCPONdjHMZ6t/+VOwX6Df/hz4p
ILGRCdcfHebdseSTbdSnwDhtnWvLST7GUF6tcvrEqizbOBfb6GSHOAtNhAcJwyN4
WZMh80cCgYEAz3ABI0H9F2QO7+6Jteir/zij5HVyp88h0dBhCOYTaJoGsV0Yh1VN
C0viaPLplAhPSvVRrIo/IXPot08FvlDXuk7MJo6ZI90Z7QgL5Q3MfRTms3jA9+Ao
iRvcUs5R4LTRZBahpCyBv/VjH/pPzgkLNfXX+vIDhKtm0aoJH6XCSH8CgYEAuibS
eIdgOwFqR+B6tOCig7j5t79Euymmjvz8PSz7ayB4Q9ovvQ0ZNodRTg0oejHss2LV
nCYAaZLMt23j0CJUxbZ4xUfalpcwABcMuV8yO1FC/AEOqVhoOK/FLJguHfmYSsI2
2KBfEcW7f1vd4v8F1HOMA9Yk/fkv/x4lKFmE2nMCgYEAilj8GUTAhKIyKCliZRVp
6Q0gmZUPRAYsWx/sJ6AzH5dikVYyrsfgW4Ff3njr+dPU9nxI3ZdSZYBFnEQy42xN
hK9bDvgaAMZMrT6pmDmswVt4RghqQqeYwWD4f62lBAX0hRlm8vTQEHObic9K/HIh
rPpq8q4IVKpwJ7OM5DOMMQcCgYAFJCFX9tUvjAB1b7uz1yhl3uv2qS+qw6G3/UCy
J9XhxYnMxe/flscFfINAVpixl0NkSOyBXYNRZx6ESmKqUuhodXusZymgUxieSASv
8fMfNEVXVGglQS3PsvsNGj7b0RLlrat6HCPEB+P/xnfAVy7ACVjqmjV3VjR/JUP9
c0t6BQKBgQCdDfkLW1rYlrx1A3v9piQ9WgeijIlV1Ex2q1dyoGfrAY3BaE1SoBsJ
h9jfdttAOda+wm1YU7PL3Fb8fWWCiBiCcVC8a2oZRaw4M5d65UqFF4i/B6haj/+Z
wK/eW+EtfSH6isDw22b6iU7JG7E00W85DAiyvukHlmKrlmrhhq8gFw==
-----END RSA PRIVATE KEY-----";
        $jwtClaim = $this->base64url_encode(json_encode(array(
            "iss" => $clientId,
            "iat" => $issuedAtTime,
            "sub" => $userId,
            "aud" => "account-d.docusign.com",
            "scope" => "signature impersonation", // issued at time
            "exp" => $expiredAtTime // expiration time     
        )));
        $jwtHeader = str_replace(['+', '/', '='], ['-', '_', ''], $jwtHeader);

        $jwtClaim = str_replace(['+', '/', '='], ['-', '_', ''], $jwtClaim);
        openssl_sign(
            $jwtHeader.".".$jwtClaim,
            $jwtSig,
            $private_key,
            "sha256WithRSAEncryption"
        );
        $jwtSign = $this->base64url_encode($jwtSig);
        $jwtSig = str_replace(['+', '/', '='], ['-', '_', ''], $jwtSig);
        //{Base64url encoded JSON header}.{Base64url encoded JSON claim set}.{Base64url encoded signature}
        $code = $jwtHeader.".".$jwtClaim.".".$jwtSign;
        // dd($code);
        $client_id = env('DOCUSIGN_CLIENT_ID_INSURANCE');
        $client_secret = env('DOCUSIGN_CLIENT_SECRET_INSURANCE');

        $integrator_and_secret_key = "Basic " . utf8_decode(base64_encode("{$client_id}:{$client_secret}"));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://account-d.docusign.com/oauth/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        $post = array(
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $code,
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        $headers = array();
        $headers[] = 'Cache-Control: no-cache';
        // $headers[] = "authorization: $integrator_and_secret_key";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        // dd($result);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        $decodedData = json_decode($result);
        // dd($decodedData);
        $request->session()->put('docusign_auth_code', $decodedData->access_token);
        return redirect('admin/insurance')->with('success', 'Docusign Succesfully Connected');
        // // For user info
        // $ch1 = curl_init();
        // curl_setopt($ch1, CURLOPT_URL, 'https://account-d.docusign.com/oauth/userinfo');
        // curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
        // $headers = array();
        // $headers[] = 'Cache-Control: no-cache';
        // $headers[] = "authorization:Bearer ".$decodedData->access_token;
        // curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers);

        // $result1 = curl_exec($ch1);
        // $userDetail = json_decode($result1);
        // // dd(json_decode($result1));
        // // dd($userDetail->accounts[0]->account_id);
        // $request->session()->put('docusign_signer_name', $userDetail->name);
        // $request->session()->put('docusign_signer_email', $userDetail->email);
        // $request->session()->put('account_id', $userDetail->accounts[0]->account_id);
        // if (curl_errno($ch1)) {
        //     echo 'Error:' . curl_error($ch1);
        // }
        // curl_close($ch1);
        
    }

    public function signDocument($id = null)
    {
        try {
            $this->args = $this->getTemplateArgs();

            $args = $this->args;


            $envelope_args = $args["envelope_args"];
            
            # Create the envelope request object
            $envelope_definition = $this->make_envelope($args["envelope_args"], $id);
            // dd($envelope_definition);
            $envelope_api = $this->getEnvelopeApi();
            # Call Envelopes::create API method
            # Exceptions will be caught by the calling function
            $api_client = new \DocuSign\eSign\client\ApiClient($this->config);
            $envelope_api = new \DocuSign\eSign\Api\EnvelopesApi($api_client);
            $results = $envelope_api->createEnvelope($args['account_id'], $envelope_definition);
            $envelope_id = $results->getEnvelopeId();

            $authentication_method = 'None'; # How is this application authenticating
            # the signer? See the `authenticationMethod' definition
            # https://developers.docusign.com/esign-rest-api/reference/Envelopes/EnvelopeViews/createRecipient
            $recipient_view_request = new \DocuSign\eSign\Model\RecipientViewRequest([
                'authentication_method' => $authentication_method,
                'client_user_id' => $envelope_args['signer_client_id'],
                'recipient_id' => '1',
                'return_url' => $envelope_args['ds_return_url'],
                'user_name' => 'DiyCars', 'email' => 'info@diycars.com'
            ]);

            // $results = $envelope_api->createRecipientView($args['account_id'], $envelope_id, $recipient_view_request);

            return redirect()->to($results['url']);
        } catch (Exception $e) {
            dd($e);
        }
    }


    private function make_envelope($args, $id)
    {
        $insuranceP = Insurance::where('id', $id)->first();
        $insurancePart = Admin::where('id', $insuranceP->partner_id)->first();
        if($insurancePart){
            $insurnacePEmail = $insurancePart->email;
            $insurnacePName = $insurancePart->firstname;
        }
        $insurerId = User::where('id', $insuranceP->user_id)->first();
        $insurerEmail = $insurerId->email;
        $insurerName = $insurerId->name;
        
        $pdfName = $insuranceP->insurance_pdf;
        if(empty($pdfName)){
            return redirect()->back()->with('error', 'PDF not found');
        }
        

        $filename = $pdfName;
        // $filename = "Dummy-Pdf.pdf";

        $demo_docs_path = asset('insurance_form/'.$pdfName);
        // dd($demo_docs_path);
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        $content_bytes = file_get_contents($demo_docs_path, false, stream_context_create($arrContextOptions));
        $base64_file_content = base64_encode($content_bytes);
       
        $document = new \DocuSign\eSign\Model\Document([ # create the DocuSign document object
            'document_base64' => $base64_file_content,
            'name' => 'Insurance document', # can be different from actual file name
            'file_extension' => 'pdf', # many different document types are accepted
            'document_id' => 1, # a label used to reference the doc
        ]);
        $signer = new \DocuSign\eSign\Model\Signer([ # The signer
            'email' => $insurnacePEmail, 'name' => $insurnacePName,
            // 'email' => $insurerEmail, 'name' => $insurerName,
            'recipient_id' => "1", 'routing_order' => "1",
            # Setting the client_user_id marks the signer as embedded
            // 'client_user_id' => $args['signer_client_id'],
        ]);

        $signer2 = new \DocuSign\eSign\Model\Signer([ # The signer
            'email' => $insurerEmail, 'name' => $insurerName,
            'recipient_id' => "2", 'routing_order' => "2",
            # Setting the client_user_id marks the signer as embedded
            // 'client_user_id' => $args['signer_client_id'],
        ]);
        
        // $cc1 = new \DocuSign\eSign\Model\CarbonCopy([

        //     'email' => 'sand.kumar11feb@gmail.com', 'name' => 'abc',

        //     'recipient_id' => "2", 'routing_order' => "2"]);
        
        
        $sign_here = new \DocuSign\eSign\Model\SignHere([ # DocuSign SignHere field/tab
            'anchor_string' => '/sn1/', 'anchor_units' => 'pixels',
            'anchor_y_offset' => '10', 'anchor_x_offset' => '20',
        ]);

        $sign_here2 = new \DocuSign\eSign\Model\SignHere([

            'anchor_string' => '/sn1/', 'anchor_units' =>  'pixels',

            'anchor_y_offset' => '10', 'anchor_x_offset' => '20']);

            // 'carbon_copies' => [$cc1]

        
        $signer->settabs(new \DocuSign\eSign\Model\Tabs(['sign_here_tabs' => [$sign_here]]));

        $signer2->settabs(new \DocuSign\eSign\Model\Tabs(['sign_here_tabs' => [$sign_here2]]));

        $envelope_definition = new \DocuSign\eSign\Model\EnvelopeDefinition([
            'email_subject' => "New Document.",
            'documents' => [$document],
            'recipients' => new \DocuSign\eSign\Model\Recipients(['signers' => [$signer, $signer2]]),
            'status' => "sent", # requests that the envelope be created and sent.
        ]);

        return $envelope_definition;
    }

    /**
     * Getter for the EnvelopesApi
     */
    public function getEnvelopeApi(): EnvelopesApi
    {
        $this->config = new Configuration();
        $this->config->setHost($this->args['base_path']);
        $this->config->addDefaultHeader('Authorization', 'Bearer ' . $this->args['ds_access_token']);
        $this->apiClient = new ApiClient($this->config);

        return new EnvelopesApi($this->apiClient);
    }

    /**
     * Get specific template arguments
     *
     * @return array
     */
    private function getTemplateArgs()
    {
        $envelope_args = [
            'signer_client_id' => $this->signer_client_id,
            'ds_return_url' => route('docusign.sign.insurance')
        ];
        $args = [
            'account_id' => env('DOCUSIGN_ACCOUNT_ID'),
            'base_path' => env('DOCUSIGN_BASE_URL'),
            'ds_access_token' => Session::get('docusign_auth_code'),
            'envelope_args' => $envelope_args
        ];

        return $args;
    }
}
