<?php
include 'restAuth.php';    // tickets tokons and secure data
function myCurl() {
    $curlHeader = array(
        "cache-control: no-cache",	
        "content-type: application/json",		
    );
    $curlPost = "{\"username\":\"devnetuser\",\n\"password\":\"Cisco123!\"\n}";
    $curlData = "/ticket";
    $curlAddress = "https://devnetapi.cisco.com/sandbox/apic_em/api/v1";
	$curlCustom = "POST";
    $curl = curl_init();    
	echo $curlAddress . $curlData . "\r\n"; //debug
    curl_setopt_array($curl, array(
        CURLOPT_SSL_VERIFYPEER => false,    //disables ssl server cert verify check
        CURLOPT_SSL_VERIFYHOST => false,    //disables ssk host cert verify check
        CURLOPT_URL => $curlAddress . $curlData,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 300,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $curlCustom,
        CURLOPT_POSTFIELDS => $curlPost,
        CURLOPT_HTTPHEADER => $curlHeader, //restAuth contains the auth Tokens. This also need to be update to return JSON instead of include
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
		print_r($response);
	    return $response;
	    echo "CATSf";
    } 
}
myCurl();
if (isset($_GET['curlData']) & isset($_GET['curlAddress'])) {
    $curlHeader = $apicAuth;
    $curlPost = "";
    $curlData = $_GET['curlData'];
    $curlAddress = $_GET['curlAddress'];       
    $reponse = myCurl($curlAuth, $curlData, $curlAddress);
    if ($array['http-code'] == 500) {
        echo print_r($array);
    } else { 
        $json = json_decode($response, true);
        //print_r($json);  // debug
        //echo $response;  // debug
        //echo $json['vlanId']['associationTime']; // debug
        $match = array("NAS Interface :"=>'clientInterface',"NAS Connection Type :"=>'connectionType',    
                       "NAS IP :"=>'deviceIpAddress',"NAS Name :"=>'deviceName',                    
                       "EndPoint Type :"=>'deviceType',"EndPoint IP :"=>'ipAddress',                      
                       "EndPoint MAC :"=>'macAddress',"EndPoint NAC :"=>'securityPolicyStatus',
                       "EndPoint OUI :"=>'vendor',"EndPoint VLAN:"=>'vlan');
        //echo $json['queryResponse']['entity']['0']['clientsDTO']['securityPolicyStatus'] . "\r\n";   // debug
        //echo print_r($json) . "\r\n";    // debug
        if (isset($json['queryResponse']['entity'])) { 
            for ($i = 0; $i < count($json['queryResponse']['entity']); $i++) {
                //Debug
                //echo "How many response: " . count($json['response']) . "<br>";
                echo "<br>";
                echo "Array Element: " . $i . "<br>";  
                echo "<br>";    
                foreach ($match as $x => $item) {
                    echo "<b>" . $x . "</b>" . "  " . $json['queryResponse']['entity']['0']['clientsDTO'][$item] . "<br>";    
                } 
        
            }   
            echo "<p>" . "</p>";
            echo "<p>" . "</p>";
        } else {
            echo "Unable to locate record for : " . "<font color=\"red\">" . $data . "</font>";
            echo "<p>" . "</p>"; 
            echo "<p>" . "</p>";
        }
    }   
}
//  Deconstruct to create a new ticket getting function......
function apicTicket_1(){
	$curlHeader = array(
		"cache-control: no-cache",	
		"content-type: application/json",		
	);
	$curlPost = "{\"username\":\"devnetuser\",\n\"password\":\"Cisco123!\"\n}";
    	$curlData = "/ticket";
    	$curlAddress = "https://devnetapi.cisco.com/sandbox/apic_em/api/v1";  
    	$reponse = myCurl($curlHeader, $curlPost, $curlData, $curlAddress); 
    	$json = json_decode($response, true);
	//Debug
	print_r($json);
	echo $response;
	//echo $curlPost;
	//print_r($curlHeader);
}
#apicTicket_1();
?>
