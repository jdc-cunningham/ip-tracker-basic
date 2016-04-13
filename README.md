# ip-tracker-basic
PHP PDO MySQL client ip url requested tracker

This ip-tracker tracks both the client's ip-address, the url-requested, and the time the url was requested.

There are two tables: clients and visits.

clients has the following columns: id, client_ip, num_vistits

visits has the following columns: id, client_ip, url_requested, date_requested

The tracker2.php file is included in the above of your webpage inside PHP tags like so:

<?php
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR.'tracker2.php');
?>

The track2() function inside the tracker2.php script is automatically called after the declaration of the track2() function.

Notice the local_ip variable, I've left this blank, if you're developing locally and are accessing your website on a seprate server, you would want to put your public ip address in between the quotes for local_ip. 

The track2() function checks to see if the client has ever visited your website. If the client has not visited your website, a new client
