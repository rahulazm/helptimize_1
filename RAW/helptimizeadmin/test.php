<?php


$deal = array(
 			'title' => "test",
 					
		);
		
		
		$url = "https://api.pipedrive.com/v1/deals?api_token=980507bc7e48d41ef0fc038a6e23b8353cb69c72";
				
		$ch = curl_init();
 		curl_setopt($ch, CURLOPT_URL, $url);
 		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 		curl_setopt($ch, CURLOPT_POST, true);
 
 		curl_setopt($ch, CURLOPT_POSTFIELDS, $deal);
 		$output = curl_exec($ch);
 		$info = curl_getinfo($ch);
 		curl_close($ch);
 		
 		$result = json_decode($output, 1);
			
		$deal_id =  $result['data']['id'];
		
		echo $deal_id;




   
?>