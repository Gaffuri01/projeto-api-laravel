<?php

    $ch = curl_init();

    $timeout = 5;

    curl_setopt($ch, CURLOPT_URL, 'https://pokeapi.co/api/v2/');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);

    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($http_code != 200) {
        // return http code and error message
        // print_r($data);
        // die;

        return json_encode([
            'code'    => $http_code,
            'message' => $data,
        ]);
    }
    // print_r($data);
    // die;
    return $data;