<?php

function get_code_from_api() {
    $url = "https://v2.sigmastudy.site/api/v1/auth/generate?server=1";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // Disable SSL verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo "API Error: " . curl_error($ch) . "\n";
        curl_close($ch);
        return null;
    }

    curl_close($ch);

    $data = json_decode($response, true);
    if (isset($data["success"]) && $data["success"] && isset($data["data"]["keyUrl"])) {
        $urlParts = explode("/", $data["data"]["keyUrl"]);
        return end($urlParts);
    }

    return null;
}

function get_key_from_arolinks($code) {
    $url = "https://arolinks.com/" . $code;

    $headers = [
        "Host: arolinks.com",
        "sec-ch-ua: \"Not)A;Brand\";v=\"8\", \"Chromium\";v=\"138\", \"Google Chrome\";v=\"138\"",
        "sec-ch-ua-mobile: ?0",
        "sec-ch-ua-platform: \"Windows\"",
        "upgrade-insecure-requests: 1",
        "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36",
        "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
        "sec-fetch-site: cross-site",
        "sec-fetch-mode: navigate",
        "sec-fetch-user: ?1",
        "sec-fetch-dest: document",
        "accept-encoding: identity",
        "accept-language: en-US,en;q=0.9",
        "referer: https://kaomojihub.com",
        "cookie: AppSession=25f2a605c6dc60f6e3b4c43b79458456; gt_uc_=$code"
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // Disable SSL verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    sleep(1); // mimic delay

    $html = curl_exec($ch);

    if (curl_errno($ch)) {
        echo "Request Error: " . curl_error($ch) . "\n";
        curl_close($ch);
        return null;
    }

    curl_close($ch);

    // Extract the final key
    if (preg_match('/href="https:\/\/generateed\.pages\.dev\/\?key=([^"]+)"/', $html, $matches)) {
        return $matches[1];
    }

    return null;
}

// MAIN
$code = get_code_from_api();
if ($code) {
    $key = get_key_from_arolinks($code);
    if ($key) {
        echo "Success: $key\n";
    } else {
        echo "Error: Key not found\n";
    }
} else {
    echo "Error: Failed to get code from API\n";
}
?>