<?php
/* 
Code by Lisa Bäcklin, Mittuniversitetet
Email: liba2103@student.miun.se
*/
?>
<?php
include_once("config.php");
/*Headers med inställningar för din REST webbtjänst*/

//Gör att webbtjänsten går att komma åt från alla domäner (asterisk * betyder alla)
header('Access-Control-Allow-Origin: *');

//Talar om att webbtjänsten skickar data i JSON-format
header('Content-Type: application/json');

//Vilka metoder som webbtjänsten accepterar, som standard tillåts bara GET.
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');

//Vilka headers som är tillåtna vid anrop från klient-sidan, kan bli problem med CORS (Cross-Origin Resource Sharing) utan denna.
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$user = new Login();

//Läser in vilken metod som skickats och lagrar i en variabel
$method = $_SERVER['REQUEST_METHOD'];

//Om annan metod än POST skickats skickas felmeddelande
if ($method != "POST") {
    http_response_code(405); //Method not allowed
    $response = array("message" => "Endast POST tillåts");
    echo json_encode($response);
    exit;
}

//Omvandlar body från JSON
$data = json_decode(file_get_contents("php://input"), true);

//Kontroll att username och password skickats med
if ($user->setUser($data["username"], $data["password"])) {
    //Loggar in användare
    if($user->loginUser($data["username"], $data["password"]) ) {

        $response = array("message" => "Inloggad", "user" => true);
        http_response_code(200); //Ok
    } else {
    $response = array("message" => "Felaktigt användarnamn eller lösenord");
    http_response_code(401); //Unauthorized
    }
}else {
    http_response_code(400); //Bad request
    $response = array("message" => "Skicka med användarnamn och lösenord");
    echo json_encode($response);
    exit;
}

//Skickar svar tillbaka till avsändaren
echo json_encode($response);
