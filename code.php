<?php
// Strict allowed site

// API URL
$url = "https://api-6ncwibrfrq-uc.a.run.app/googleReviews";

// Payload

$data = array(
        "businessName" =>  "Punjab Computer Centre Tripuri Town Patiala",
        "features" => "Best Computer Training institute, Best computer centre in Tripuri Town, Patiala, Best Computer institute in Tripuri Town, Patiala, Computer training centre in Tripuri Town, Patiala, Best Tally course, Best Graphic Designing course, Best Digital Marketing course",
        "category" =>  "Computer institute",
        "docId" =>  "BTHhxBRaFJPCeVH6Mu8A"  
);

// cURL request
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
curl_close($ch);

// Return JSON response
header('Content-Type: application/json');
echo $response;
?>