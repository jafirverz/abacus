<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DocuSign\eSign\Configuration;
use DocuSign\eSign\Api\EnvelopesApi;
use DocuSign\eSign\Client\ApiClient;
use Exception;
use Session;
use App\Loan;

class DocusignLoanController extends Controller
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


    public function sendPDF($id = null)
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
                $updateLoan = Loan::where('id', $id)->first();
                $updateLoan->docu_sent = 1;
                $updateLoan->save();
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
                'user_name' => 'DiyCars', 'email' => 'info@diycars.com'
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
                'scope' => 'signature',
                'client_id' => env('DOCUSIGN_CLIENT_ID_LOAN'),
                'state' => 'a39fh23hnf23',
                'redirect_uri' => 'https://diycars.com/admin/loan-application/callback',
            ];
            $queryBuild = http_build_query($params);
            $url = "https://account-d.docusign.com/oauth/auth?";

            $botUrl = $url . $queryBuild;
            
            return redirect()->to($botUrl);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something Went wrong !');
        }
    }

    /**
     * This function called when you auth your application with docusign
     *
     * @return url
     */
    public function callback(Request $request)
    {
        $code = $request->code;

        $client_id = env('DOCUSIGN_CLIENT_ID_LOAN');
        $client_secret = env('DOCUSIGN_CLIENT_SECRET_LOAN');

        $integrator_and_secret_key = "Basic " . utf8_decode(base64_encode("{$client_id}:{$client_secret}"));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://account-d.docusign.com/oauth/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        $post = array(
            'grant_type' => 'authorization_code',
            'code' => $code,
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        $headers = array();
        $headers[] = 'Cache-Control: no-cache';
        $headers[] = "authorization: $integrator_and_secret_key";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        $decodedData = json_decode($result);
        $request->session()->put('docusign_auth_code', $decodedData->access_token);
        return redirect('admin/loan-application')->with('success', 'Docusign Succesfully Connected');
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
        $loanDetail = Loan::where('id', $id)->first();
        $buyerEmail = $loanDetail->applicant_email; //'bkumarsocial30@gmail.com';
        $buyerName = $loanDetail->applicant_name ?? $buyerEmail;
        $pdfName = $loanDetail->pdf_name ?? '';
        if(empty($pdfName)){
            return redirect()->back()->with('error', 'PDF not found');
        }
        

        $filename = $pdfName;

        

        $demo_docs_path = asset('loanpdf/' . $filename);

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
            'name' => 'Loan Form', # can be different from actual file name
            'file_extension' => 'pdf', # many different document types are accepted
            'document_id' => 1, # a label used to reference the doc
        ]);
        $signer = new \DocuSign\eSign\Model\Signer([ # The signer
            'email' => $buyerEmail, 'name' => $buyerName,
            'recipient_id' => "1", 'routing_order' => "1",
            # Setting the client_user_id marks the signer as embedded
            // 'client_user_id' => $args['signer_client_id'],
        ]);

        // $signer2 = new \DocuSign\eSign\Model\Signer([ # The signer
        //     'email' => $sellerEmail, 'name' => $sellerName,
        //     'recipient_id' => "2", 'routing_order' => "2",
        //     # Setting the client_user_id marks the signer as embedded
        //     // 'client_user_id' => $args['signer_client_id'],
        // ]);

        // $cc1 = new \DocuSign\eSign\Model\CarbonCopy([

        //     'email' => 'sand.kumar11feb@gmail.com', 'name' => 'abc',

        //     'recipient_id' => "2", 'routing_order' => "2"]);

        
        $sign_here = new \DocuSign\eSign\Model\SignHere([ # DocuSign SignHere field/tab
            'anchor_string' => '/sn1/', 'anchor_units' => 'pixels',
            'anchor_y_offset' => '10', 'anchor_x_offset' => '20',
        ]);

        // $sign_here2 = new \DocuSign\eSign\Model\SignHere([

        //     'anchor_string' => '/sn1/', 'anchor_units' =>  'pixels',

        //     'anchor_y_offset' => '10', 'anchor_x_offset' => '20'
        // ]);

            // 'carbon_copies' => [$cc1]

        
        $signer->settabs(new \DocuSign\eSign\Model\Tabs(['sign_here_tabs' => [$sign_here]]));

        // $signer2->settabs(new \DocuSign\eSign\Model\Tabs(['sign_here_tabs' => [$sign_here2]]));

        $envelope_definition = new \DocuSign\eSign\Model\EnvelopeDefinition([
            'email_subject' => "New Document.",
            'documents' => [$document],
            'recipients' => new \DocuSign\eSign\Model\Recipients(['signers' => [$signer]]),
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
            'ds_return_url' => route('docusign')
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
