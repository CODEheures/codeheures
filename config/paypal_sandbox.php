<?php
return array(
    // set your paypal credential
    'client_id' => 'AQBBrRMEbQGRk0AnLqqbN95-6CcjJ2yKvfE9OooTTn6hsB_Atp7QKfZTQhb0QJl7wJF2JfajyhbTHx9x',
    'secret' => 'EIpSSwesXONYqVyUOJj8er6ayyyepc995WGM3emGCdlYh95h8j7K2wyP5xBp0suL6_cFZAB7PdrBguVJ',
    /**
     * SDK configuration
     */
    'settings' => array(
        /**
         * Available option 'sandbox' or 'live'
         */
        'mode' => 'sandbox',
        /**
         * Specify the max request time in seconds
         */
        'http.ConnectionTimeOut' => 30,
        /**
         * Whether want to log to a file
         */
        'log.LogEnabled' => true,
        /**
         * Specify the file that want to write on
         */
        'log.FileName' => storage_path() . '/logs/paypal_sandbox.log',
        /**
         * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
         *
         * Logging is most verbose in the 'FINE' level and decreases as you
         * proceed towards ERROR
         */
        'log.LogLevel' => 'FINE'
    ),
);