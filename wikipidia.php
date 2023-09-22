<?php

// Specify the API endpoint URL
$apiUrl = "https://en.wikipedia.org/w/api.php";

// Specify the parameters for the action you want to perform
$params = array(
    "action" => "query",
    "format" => "json",
    "titles" => "SQLite",
    "prop" => "extracts",
    "exintro" => true
);

// Construct the API URL with the parameters
$apiUrl .= "?" . http_build_query($params);

// Make the API request using cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);

// Decode the JSON response
$data = json_decode($response, true);

// Extract and print the article content
$page = reset($data["query"]["pages"]);
$content = $page["extract"];
echo $content;