<?php

return [
    'company'          => 'Vega Homes (Pvt) Ltd',

    // Number that receives the estimator enquiry on WhatsApp (and the floating WhatsApp button).
    // International format, digits only, no "+".
    'whatsapp_number'  => env('VEGA_WHATSAPP', '94712741577'),

    'messenger_url'    => env('VEGA_MESSENGER_URL', 'https://m.me/94712741577'),

    /*
    |--------------------------------------------------------------------------
    | Dream Home Estimator - dropdown lists (used by the public form + validation)
    |--------------------------------------------------------------------------
    */
    'districts' => [
        'Ampara', 'Anuradhapura', 'Badulla', 'Batticaloa', 'Colombo', 'Galle', 'Gampaha',
        'Hambantota', 'Jaffna', 'Kalutara', 'Kandy', 'Kegalle', 'Kilinochchi', 'Kurunegala',
        'Mannar', 'Matale', 'Matara', 'Monaragala', 'Mullaitivu', 'Nuwara Eliya',
        'Polonnaruwa', 'Puttalam', 'Ratnapura', 'Trincomalee', 'Vavuniya', 'Other',
    ],

    'design_statuses' => [
        'Not Started', 'Design in Progress', 'Design Completed',
        'Revisions Required', 'Existing Plan Available',
    ],

    'approval_statuses' => [
        'Not Submitted for Approval',
        'Submitted to Council – Pending Approval',
        'Approved by Municipal Council',
        'Approved by Urban Council',
        'Approved by Pradeshiya Sabha',
        'Revisions Required by Council',
        'Approval Required / Not Sure',
        'Not Applicable',
    ],

    'land_options' => ['Owned', 'Planning to Purchase', 'Other'],

    'room_types' => [
        'Bedroom', 'Bathroom', 'Living Room', 'Dining Room', 'Pantry',
        'Kitchen', 'Veranda', 'Store Room', 'Other',
    ],

    // Enquiry pipeline shown in the admin panel.
    'inquiry_statuses' => [
        'new'        => 'New',
        'contacted'  => 'Contacted',
        'site_visit' => 'Site Visit',
        'quoted'     => 'Quoted',
        'won'        => 'Won',
        'lost'       => 'Lost',
    ],
];
