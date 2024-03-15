<?php
error_reporting(0);
set_time_limit(900);
ini_set('memory_limit', '1024M');
//post data
$db_name = $_POST['db_name'];
$db_host = $_POST['db_host'];
$db_user = $_POST['db_user'];
$db_pass = $_POST['db_pass'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$states = $_POST['states'];
$cities = $_POST['cities'];
//env contents
$app_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']!='off') ? 'https://' : 'http://';		
$app_url .= $_SERVER['HTTP_HOST'];
$app_key = base64_encode(random_bytes(32));
$new_envcontent = "APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:$app_key
APP_DEBUG=true
APP_URL=$app_url

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=$db_host
DB_PORT=3306
DB_DATABASE=$db_name
DB_USERNAME=$db_user
DB_PASSWORD=$db_pass

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DRIVER=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME='${APP_NAME}'

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY='${PUSHER_APP_KEY}'
MIX_PUSHER_APP_CLUSTER='${PUSHER_APP_CLUSTER}'
";

//check database connection
if ($_REQUEST['check'] == 'db') {

    try {
        $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        //check if table exists
        $check_db = $conn->query("SHOW TABLES LIKE 'site_settings'");
        if ($check_db->rowCount() == 0 or die(json_encode([
            'result' => 'failed',
            'message' => 'Error Database conflict: Seems Ecourier is already installed on this server'
        ])));

        die(json_encode([
            'result' => 'success'
        ]));

       
    } catch (PDOException $key) {
        die(json_encode([
            'result' => 'failed',
            'message' => 'Error: Database connections failed'
        ]));
    }
}

//installation
if ($_REQUEST['check'] == 'install') {
    
    try {
        
        $env_file = '../.env';
		file_put_contents($env_file, $new_envcontent); 
        $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        
        $query = file_get_contents("database/database.sql");
        $stmt = $conn->prepare($query);
        $stmt->execute();
       
        //update admin details
		$query = "UPDATE users SET firstname='$firstname', lastname='$lastname', email='$email' WHERE username='admin'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
        
        //check if states location is added
        if (file_exists('database/states.sql') && $states  == 'add') {
            $query = file_get_contents("database/states.sql");
            $stmt = $conn->prepare($query);
            $stmt->execute();	
        }
        //check if cities location is added
        if (file_exists('database/cities.sql')  && $cities  == 'add') {
            $query = file_get_contents("database/cities.sql");
            $stmt = $conn->prepare($query);
            $stmt->execute();	
        }
          
        
        $response = '<div> <p class="text-danger">Please delete the "install" folder from the server.</p> <p class="lead my-3">Default admin username: admin and paswword is: 12345678. Please change the admin password as soon as possible.</p> </div>';
        $response .= '<p class="text-success">Email address of admin has been updated successfully!</p>';
        $response .= '<a href="../" class="btn btn-primary">Go to website</a> <a href="../dashboard" class="btn btn-success">Go to Admin Panel</a>';

        die(json_encode([
            'result' => 'success',
            'message' => $response
        ]));
    } catch (PDOException $key) {
        die(json_encode([
            'result' => 'failed'
        ]));
    }
    
    
}
