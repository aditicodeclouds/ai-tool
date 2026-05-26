<?php


    $data = [
        "name" => trim($_POST['name']),
        "email" => trim($_POST['email']),
        "company" => trim($_POST['company']),
        "industry" => trim($_POST['industry']),
        "goal" => trim($_POST['goal'])
    ];

    $webhook = "https://hook.eu1.make.com/rmmc3ir9pbxl2thndqtkb2elvx1q1svw";

    $ch = curl_init($webhook);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        //'Authorization: ' . $passkey
    ]);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo curl_error($ch);
    } else {
        echo $response;
    }

    curl_close($ch);

    echo " - Submitted successfully";

?>