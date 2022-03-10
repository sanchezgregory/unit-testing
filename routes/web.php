<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    $cURLConnection = curl_init();

    curl_setopt($cURLConnection, CURLOPT_URL, 'https://zt-eng.s3.us-east-1.amazonaws.com/fe-challenge/survey.json');
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

    $phoneList = curl_exec($cURLConnection);
    curl_close($cURLConnection);

    $jsonArrayResponse = json_decode($phoneList);
    $showIndformation = [];

    foreach ($jsonArrayResponse->nodes as $items) {
        foreach ($items as $item => $value) {
            if ($item == 'page_title' && (!is_null($value) || $value != '')) {
                $showIndformation[][$item] = $value;
            }
        }
    }

    echo "<ul id='listOrder' class='listOrder'>";
    foreach ($showIndformation as $key => $inf) {
        echo "<li>" . $inf['page_title'] . "</li>";
    }

    $str = <<<IDENTIFIER
    <script>

    var parentNode = document.getElementById('listOrder');
    var e = document.getElementById('listOrder').children;
        [].slice.call(e).sort(function(a, b) {
            if (a.textContent > b.textContent) return 1;
            if (a.textContent < b.textContent) return -1;
            return 0;
        }).forEach(function(val) {
            parentNode.appendChild(val);
        });

    </script>
    IDENTIFIER;

    echo $str;

    //return view('testJs');

});
