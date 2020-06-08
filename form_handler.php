<?php


require __DIR__ . "/vendor/autoload.php";

use Twilio\Rest\Client;


/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */

$link = mysqli_connect("localhost", "root", "root", "4aces");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// echo "Done";

$email = $_REQUEST['email'];
$name = $_REQUEST['name'];
$phone = $_REQUEST['phone'];

// print_r($phone);
 
// Attempt insert query execution
$sql = "INSERT INTO outbound_leads (name, email, phone) VALUES ('$name', '$email', '$phone')";

if(mysqli_query($link, $sql)){
    // echo "Records inserted successfully.";
} else{
    // echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
// Close connection
mysqli_close($link);


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$twilioSid    = getenv('TWILIO_SID');
$twilioToken  = getenv('TWILIO_TOKEN');

$twilio = new Client($twilioSid, $twilioToken);

$message = $twilio->messages
                 ->create(
                     "whatsapp:+91" . $phone,
                     array(
                              "body" => "Hi, $name \nGreetings from 4Aces 😀🏍
                              \nPlease download the product brochure sent below
                              \n\nWhat would you like to know :
1. Product FAQ
2. Service
3. Finance Facility
4. Exchange Facility

Type *menu* at any step to bring this up",
                              "from" => "whatsapp:+14155238886",
                          )
                 );

                 
$message = $twilio->messages
                 ->create(
                     "whatsapp:+91" . $phone,
                     array(
                              "body" => "Brochure",
                              "from" => "whatsapp:+14155238886",
                              "MediaUrl" => "https://drive.google.com/uc?export=download&id=1OozAim8nylN8ipzogX5GpMU30hsIWcIU"
                          )
                 );





header("Location: index.html");
exit();


?>