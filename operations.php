<?php
$data = json_decode(file_get_contents('php://input'), true);
$key = 'Your Key';
switch ($data["key"]) {
  case 'getlist':
    if($data['query'] != ""){
      $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://maps.googleapis.com/maps/api/place/textsearch/json?query='.$data['query'].'&fields=name%2Cplace_id&key='.$key,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    
    $dt = json_decode($response,true);
    $datastring = ""; 
    foreach ($dt['results'] as $key => $value) {
      $datastring .= "<tr data-id='".($key + 1)."'><td>".($key + 1)."</td><td>".$value['name']."</td><td>".$value['formatted_address']."</td><td>".$value['place_id']."</td><td class='updateno' onclick='getPlaceDetails(\"".$value['place_id']."\",\"".($key+1)."\")'>Get Contact No </td></tr>";        
      
     }
     echo json_encode(array('status'=>true,'data'=>$datastring));
    }
    break;
  case 'getno':
    if($data['placeid'] != ""){
      $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://maps.googleapis.com/maps/api/place/details/json?placeid='.$data['placeid'].'&key='.$key,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    
    $dt = json_decode($response,true);
    // print_r($dt); exit;
    $datastring = @$dt['result']['formatted_phone_number']; 
     echo json_encode(array('status'=>true,'data'=>$datastring));
    }
    break;
  default:
    echo 'invalid data';
    break;
}

?>