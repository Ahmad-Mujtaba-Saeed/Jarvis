<?php
include 'auto_loader.php';
require_once 'dbh.inc.php';
session_start();

if (isset($_POST['inputField'])) {
    $phrase = $_POST['inputField'];
    $lower_phrase = strtolower($phrase);
    $words = explode(" ", $lower_phrase);
    if ($phrase == 12345 || isset($_SESSION['password'])) {
        $_SESSION['password'] = true;
        $user = new user($conn);
        $user->user_info($conn);
        $uname = $user->uname;
        $call_name = $user->callname;
        foreach ($words as $word) {

            //filtering the user input

            if ($word == 'what' || $word == "what's") {
                foreach ($words as $inner) {
                    if ($inner == 'my' || $lower_phrase == "what is my name") {

                        $result = "" . $call_name . "Your name is " . $uname . "";
                        header("location:../index.php?result=" . $result);
                    } elseif ($inner == 'age' || $lower_phrase == "what is my age") {

                        $age = $user->age;
                        $result = "" . $call_name . "Your age is " . $age . "";
                        header("location:../index.php?result=" . $result);
                    } elseif ($inner == 'height' || $lower_phrase == "what is my height") {

                        $height = $user->height;
                        $result = "" . $call_name . "Your height is " . $height . "";
                        header("location:../index.php?result=" . $result);
                    } elseif ($inner == 'color' || $lower_phrase == "what is my favourite color") {

                        $color = $user->fav_color;
                        $result = "" . $call_name . "Your favourite color is " . $color . "";
                        header("location:../index.php?result=" . $result);
                    } elseif ($inner == 'food' || $lower_phrase == "what is my favourite food") {

                        $food = $user->fav_food;
                        $result = "" . $call_name . "Your favourite food is " . $food . "";
                        header("location:../index.php?result=" . $result);
                    } elseif ($inner == 'your' || $lower_phrase == "what is your name") {

                        $food = $user->fav_food;
                        $result = "" . $call_name . "My name is jarvis and I am personal assistant of " . $uname . "";
                        header("location:../index.php?result=" . $result);
                    }
                }
            } elseif ($word == 'who' || $word == "who's") {
                foreach ($words as $inner) {
                    if ($inner == "owner" || $inner == "creator" || $lower_phrase == "who is the creator of you") {

                        $result = "" . $call_name . "My creator is " . $uname . "";
                        header("location:../index.php?result=" . $result);
                    }

                }
            } elseif ($word == 'can' || $word == 'open' || $word == 'call' || $word == 'run' || $word == "please" || $word == "change") {
                foreach ($words as $inner) {
                    $lastword = end($words);
                    if ($inner == "call" || $lower_phrase == "can you call me " . $lastword . "") {

                        $user->user_changeing($lastword, $conn);
                        $result = "OK sir changing your calling name in my database . Next time I will call you " . $lastword . "";
                        header("location:../index.php?result=" . $result);
                    } elseif ($inner == "remember" || $inner == "can you remember") {

                        $user->remember($lastword, $conn);

                        $result = "OK " . $call_name . " I have saved this in my database " . $lastword . "";
                        header("location:../index.php?result=" . $result);
                    } elseif ($inner == "chrome" || $inner == "open chrome") {

                        $targetURL = "https://www.google.com"; // The URL you want to open

                        // Generate HTML content with a redirect
                        $html = "<!DOCTYPE html>
                        <html>
                        <head>
                        <meta http-equiv='refresh' content='0;url=$targetURL'>
                        </head>
                        <body>
                        </body>
                        </html>";

                        // Print the HTML content
                        echo $html;
                        $result = "" . $call_name . "successfully launched " . $lastword . "";
                        header("location:../index.php?result=" . $result);
                    }
                }
            } elseif ($word == "jarvis") { //CHAT GPT 

                // API key
                $apiKey = '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';

                $apiEndpoint = "https://api.openai.com/v1/chat/completions";


                $headers = array(
                    "Content-Type: application/json",
                    "Authorization: Bearer " . $apiKey
                );


                $messages = array(
                    array("role" => "system", "content" => "You are a helpful assistant."),
                    array("role" => "user", "content" => $lower_phrase)
                );


                $payload = json_encode(
                    array(
                        "messages" => $messages,
                        "model" => "gpt-3.5-turbo"
                    )
                );


                $ch = curl_init($apiEndpoint);


                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);


                $response = curl_exec($ch);


                if (curl_errno($ch)) {
                    echo "cURL Error: " . curl_error($ch);
                    exit;
                }


                curl_close($ch);


                $data = json_decode($response, true);


                if (isset($data["choices"][0]["message"]["content"])) {
                    $result = $data["choices"][0]["message"]["content"];

                    $file = "result.txt";

                    file_put_contents($file, $result);
                    echo "Data has been written to the file."; //writhing the result into a txt file

                    header("location:../index.php?result=1");
                } else {
                    echo "Assistant reply not found in response.";
                }

            }

        }

    } else {
        header("Location:../index.php?result=key");
    }

}
?>