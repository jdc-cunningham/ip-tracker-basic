# ip-tracker-basic
What is it: PHP PDO MySQL client-ip url-requested tracker

Anytime a webpage with this tracker included, will trigger an ip request and current url request to be stored into the Tracking database.

This ip-tracker tracks both the client's ip-address, the url-requested, and the time the url was requested.

I use PHPMyAdmin when working with MySQL
The database called Tracking with collation utf8_unicode_ci has to be created, then import the two tables
There are two tables: clients and visits.

clients has the following columns: id, client_ip, num_vistits

visits has the following columns: id, client_ip, url_requested, date_requested

The tracker2.php file is included above the <!DOCTYPE HTML> tag of your webpage inside PHP tags like so:

<?php
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR.'tracker2.php');
?>

The track2() function inside the tracker2.php script is automatically called after the declaration of the track2() function.

Notice the local_ip variable, I've left this blank. The local_ip variable serves to allow tracking your public ip-address if you're checking your website hosted on another server.

If you don't want to capture your ip-address, simply insert your current public ip-address inbetween the quotes for the varialbe $local_ip

You can determine your public ip-address by going to Google.com and searching "What is my ip address" or other means through command line or bash such as ipconfig or ifconfig(Linux).

The track2() function first checks to see if the client has ever visited your website. If the client has not visited your website, a new clients row will be created as well as a new visits row. If this client has visited before, the clients row with the matching client_ip address will be updated.

Notice the way client_ip is gathered, if the website is not using a proxy that is, only one ip-address is present, client_ip is simply reported by $_SERVER['REMOTE_ADDR'] otherwise the if statement following checks for multiple ip-addresses and if there is more than one ip-address, the last ip-address is recorded.
