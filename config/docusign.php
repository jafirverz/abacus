<?php

return [

    /*
     |--------------------------------------------------------------------------
     | Docusign Host
     |--------------------------------------------------------------------------
     |
     | Change this to production before going live
     |
     */

    'host' => 'https://demo.docusign.net/restapi',

    /*
     |--------------------------------------------------------------------------
     | Docusign Default Credentials
     |--------------------------------------------------------------------------
     |
     | These are the credentials that will be used if none are specified
     |
     */

    'username' => env('DOCUSIGN_USERNAME', 'b97394fb-04e2-431c-afa3-8bd9bbdf332a'),

    'password' => env('DOCUSIGN_PASSWORD', 'VerzDev123$%'),

    'integrator_key' => env('DOCUSIGN_INTEGRATOR_KEY', 'e4e1f07b-ee26-4751-88d2-d26017baa4e5')


];
