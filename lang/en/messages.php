<?php

return [

    /*
    |--------------------------------------------------------------------------
    | General Application Messages
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to display general messages
    | to users for various actions such as CRUD operations, authentication,
    | and more.
    |
    */

    // CRUD
    'created' => ':Item has been successfully created.',
    'updated' => ':Item has been successfully updated.',
    'deleted' => ':Item has been successfully deleted.',
    'retrieved' => ':Item data retrieved successfully.',
    'processed' => ':Item has been successfully processed.',

    // Common Errors
    'not_found' => ':Item not found.',
    'unauthorized' => 'Access is not authorized.',
    'forbidden' => 'You do not have permission.',
    'self_forbidden' => 'You cannot perform this action on yourself.',
    'validation_failed' => 'Validation failed.',
    'operation_failed' => 'The operation could not be completed.',
    'process_failed' => 'An error occurred while processing the request.',
    'invalid' => 'The :attribute is invalid.',
    'something_went_wrong' => 'Something went wrong.',

    // Authentication
    'registered' => 'Registration successful.',
    'registration_failed' => 'Registration failed. Please check the data you entered.',
    'logged_in' => 'Successfully logged in.',
    'logged_out' => 'Successfully logged out.',
    'login_failed' => 'Login failed. Please check your email and password.',
];
