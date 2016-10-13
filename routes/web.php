<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

use Illuminate\Http\Request;

Route::get('/', function () {

    $query = http_build_query([
        'client_id' => 3,
        'redirect_uri' => 'http://consumer.local/callback',
        'response_type' => 'code',
        'scope' => 'place-orders check-status',
    ]);

    return redirect('http://laravel.local/oauth/authorize?' . $query);
});

Route::get('callback', function (Request $request) {

    $http = new GuzzleHttp\Client;

    $response = $http->post('http://laravel.local/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => 3,
            'client_secret' => 'IJB8THYtn9h1X7WFz0ThShbb7KE2894DrKvrBVPH',
            'redirect_uri' => 'http://consumer.local/callback',
            'code' => $request->code
        ]
    ]);

    return json_decode((string) $response->getBody(), true);

});