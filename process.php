<?php
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);

    // Collect and sanitize data
    $data = [
        "name"     => trim($_POST['name'] ?? ''),
        "email"    => trim($_POST['email'] ?? ''),
        "company"  => trim($_POST['company'] ?? ''),
        "industry" => trim($_POST['industry'] ?? ''),
        "goal"     => trim($_POST['goal'] ?? ''),        
        "solution"     => trim($_POST['solution'] ?? '')
    ];

    // --------------------
    // Spam Validation
    // --------------------

    if (!empty($_POST['website'])) {
        die("Spam detected.");
    }

    // Required fields
    foreach ($data as $field => $value) {
        if (empty($value)) {
            die("Error: {$field} is required.");
        }
    }

    // Email validation
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        die("Error: Invalid email address.");
    }

    // Name validation
    if (strlen($data['name']) < 2) {
        die("Error: Invalid name.");
    }

    // Goal validation
    if (strlen($data['goal']) < 10) {
        die("Error: Please provide more details in the goal field.");
    }

    // Block disposable/test emails
    $blockedDomains = [
        'mailinator.com',
        '10minutemail.com',
        'tempmail.com',
        'guerrillamail.com'
    ];

    $emailDomain = strtolower(substr(strrchr($data['email'], "@"), 1));

    if (in_array($emailDomain, $blockedDomains)) {
        die("Error: Temporary email addresses are not allowed.");
    }

    // Block obvious test submissions
    $blockedWords = [
        'test',
        'testing',
        'asdf',
        'qwerty',
        'dummy'
    ];

    $combinedText = strtolower(
        $data['name'] . ' ' .
        $data['company'] . ' ' .
        $data['goal']
    );

    foreach ($blockedWords as $word) {
        if (strpos($combinedText, $word) !== false) {
            die("Error: Invalid submission detected.");
        }
    }

    // --------------------
    // Send to Make.com
    // --------------------

    $webhook = "https://hook.eu1.make.com/rmmc3ir9pbxl2thndqtkb2elvx1q1svw";

    $ch = curl_init($webhook);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        die('cURL Error: ' . curl_error($ch));
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($httpCode >= 200 && $httpCode < 300) {
        echo "Submitted successfully.";
    } else {
        echo "Webhook failed. Response: " . $response;
    }


    // $data = [
    //     "name" => trim($_POST['name']),
    //     "email" => trim($_POST['email']),
    //     "company" => trim($_POST['company']),
    //     "industry" => trim($_POST['industry']),
    //     "goal" => trim($_POST['goal'])
    // ];

    // $webhook = "https://hook.eu1.make.com/rmmc3ir9pbxl2thndqtkb2elvx1q1svw";

    // $ch = curl_init($webhook);

    // curl_setopt($ch, CURLOPT_POST, true);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    // curl_setopt($ch, CURLOPT_HTTPHEADER, [
    //     'Content-Type: application/json',
    //     //'Authorization: ' . $passkey
    // ]);

    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // $response = curl_exec($ch);

    // if (curl_errno($ch)) {
    //     echo curl_error($ch);
    // } else {
    //     echo $response;
    // }

    // curl_close($ch);

    // echo " - Submitted successfully";

?>