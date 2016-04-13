<?php
// Author: Jacob David C Cunningham
// My website: cunninghamwebdd.com
// Title: Web tracker v2
// Date created: 04/12/2016 10:31 PM 
// Location: Sedalia MO

// Get your public ip-address if you're developing locally so that you don't log your own ip-address
// If you don't know your public ip-address, you can go to Google.com and search "What is my ip address"

// This is written with PDO to MySQL database query
function track2() {
    // Your local ip address
    // Leave this blank eg. "" if you don't care about capturing your own ip address
    $local_ip = "";

    // Get client's ip address
    // Store as string
    $client_ip = $_SERVER['REMOTE_ADDR'];
    
    // This gets the current address that triggered this tracker
    $url_requested = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    // Additional check for proxy
    // If more than one ip address is returned, the last one is captured
    if ( array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
	$client_ip = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
    }

    // Sompare client's ip address to yours
    if ($client_ip != $local_ip) {
	// Define id, date_requested, initial num_visits
	$id = "";
	$dt = new DateTime();
	$now = $dt->format("m-d-Y h:i");
	$date_requested = $now;
	$num_visits = 1;
	
	// Database connection
	try {
	    $dbusername = "";
	    $dbpassword = "";
	    $link = new PDO('mysql:host=localhost;dbname=Tracking',$dbusername,$dbpassword);
	    $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (PDOException $e) {
	    echo 'Connection failed: ' . $e->getMessage();
	}
        // start the check if this client has visited your website before
        $stmt = $link->prepare('SELECT COUNT(*) FROM clients where client_ip=:client_ip');
	$stmt->bindParam(':client_ip', $client_ip, PDO::PARAM_STR);
	$stmt->execute();
	$client_count = $stmt->fetchColumn(0);
	if($client_count > 0) {
	    // This means that this page has been visited before by this client
	    // Increment clients num_visits
	    $stmt2 = $link->prepare('UPDATE clients SET num_visits=num_visits+1 WHERE client_ip=:client_ip');
	    $stmt2->bindParam(':client_ip', $client_ip, PDO::PARAM_STR);
	    $stmt2->execute();
	    // Insert visits entry
	    $stmt3 = $link->prepare('INSERT INTO visits VALUES (:id, :client_ip, :url_requested, :date_requested)');
	    $stmt3->bindParam(':id', $id, PDO::PARAM_INT);
	    $stmt3->bindParam(':client_ip', $client_ip, PDO::PARAM_STR);
	    $stmt3->bindParam(':url_requested', $url_requested, PDO::PARAM_STR);
	    $stmt3->bindParam(':date_requested', $date_requested, PDO::PARAM_STR);
	    $stmt3->execute();
	}
	else {
	    // Client has not visited your website before
	    // Create new entry for clients
	    $stmt4 = $link->prepare('INSERT INTO clients VALUES (:id, :client_ip, :num_visits)');
	    $stmt4->bindParam(':id', $id, PDO::PARAM_INT);
	    $stmt4->bindParam(':client_ip', $client_ip, PDO::PARAM_STR);
	    $stmt4->bindParam(':num_visits', $num_visits, PDO::PARAM_INT);
	    $stmt4->execute();
	    // Create new entry for visits
	    $stmt5 = $link->prepare('INSERT INTO visits VALUES (:id, :client_ip, :url_requested, :date_requested)');
	    $stmt5->bindParam(':id', $id, PDO::PARAM_INT);
	    $stmt5->bindParam(':client_ip', $client_ip, PDO::PARAM_STR);
	    $stmt5->bindParam(':url_requested', $url_requested, PDO::PARAM_STR);
	    $stmt5->bindParam(':date_requested', $date_requested, PDO::PARAM_STR);
	    $stmt5->execute();
	}
    }
}

track2();

?>
