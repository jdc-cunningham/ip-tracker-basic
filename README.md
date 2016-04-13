# ip-tracker-basic


## What is it?


ip-tracker-basic is a client-ip and url-requested tracker.


## What's included:


tracker2.php

clients.sql

visits.sql


## What's required to use this tracker?


PHP with PDO enabled 

MySQL database

Database name: Tracking

Collation: utf8_unicode_ci


### Additional notes


I use PHPMyAdmin to create and manage my databases.


## How to use ip-tracker-basic


After creating the database called **Tracking** with collation *utf8_unicode_ci*, you will need to import the included tables: *clients.sql* and *visits.sql*


If you'd prefer to create the tables, the columns for each table are:


clients.sql : 

id, client_ip, num_visits


visits.sql  : 

id, client_ip, url_requested, date_requested


Next you will need to open up tracker2.php and enter your database's user account and password in order to query the Tracking database on your webserver.


Then you'll just upload the tracker2.php file into your webserver and include it at the top of your webpage like
this:


```
<?php
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR.'tracker2.php');
?>
```


## Additional notes


If you don't want to capture your own ip-address when working on your website hosted on a seperate server from your local machine, find the $local_ip variable and set this variable as your public ip-address. Store the ip-address as a string like
so:


```
$local_ip = "###.###.###.###";
```


You can find your public ip-address by going to Google.com and searching "What is my ip address".


The client ip-address is captured by ```$_SERVER['REMOTE_ADDR']``` and if the client has more than one ip-address for this url-request, the last ip-address is used.
