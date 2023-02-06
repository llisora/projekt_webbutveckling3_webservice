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

//Läser in vilken metod som skickats och lagrar i en variabel
$method = $_SERVER['REQUEST_METHOD'];

//Om en parameter av id finns i urlen lagras det i en variabel
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

//Ny instans
$reservation = new Booking();


switch ($method) {
    case 'GET':
        //Kollar om id är skickat och hämtar i så fall ut enskild kurs
        if(isset($id)) {
            $response = $reservation->getReservationById($id);
            //Annars skriv ut alla kurser
        }else {
            $response = $reservation->getReservation();
        }

        if (count($response) === 0) {
            //Lagrar ett meddelande som sedan skickas tillbaka till anroparen
            $response = array("message" => "Theres nothing to get yet");

            http_response_code(404); //not found
        } else {
            //Skickar en "HTTP response status code"
            http_response_code(200); //Ok - The request has succeeded
        }
        break;
    case 'POST':
        //Läser in JSON-data skickadmed anropet och omvandlar till ett objekt.
        $data = json_decode(file_get_contents("php://input"), true);

        if($reservation->setReservation($data['name'], $data['time'], $data['date'], $data['quantity'])) {
            //Skapa en katt
            if($reservation->createReservation()) {
                $response = array("message" => "Course added");
                http_response_code(200); //OK
            }else {
                $response = array("message" => "Something went wrong when adding a reservation");
                http_response_code(500); //internal server error
            }
        }else{
            //ej korrekt inmatning
            $response = array("message" => "Check the values and try again... make sure everything is written correctly!");
            http_response_code(400); //bad request
        }
        break;
    case 'PUT':
       //Läser in JSON-data skickad med anropet och omvandlar till ett objekt.
       $data = json_decode(file_get_contents("php://input"), true);

       if($reservation->setReservationAndId($data['id'], $data['name'], $data['time'], $data['date'], $data['quantity'])) {
           //Uppdatera katt
           if($reservation->updateReservation()) {
               $response = array("message" => "Reservation updated");
               http_response_code(201); //created
           } else {
            $response = array("message" => "Something went wrong when updating your reservation");
            http_response_code(500); //Internal server error
           }
       }else{
           //ej korrekt inmatning
           $response = array("message" => "Check the values and try again... make sure everything is written correctly!");
           http_response_code(400); //bad request
       }
        break;
    case 'DELETE':
        //Kollar om id är medskickat
        if (!isset($id)) {
            http_response_code(400);
            $response = array("message" => "Make sure that you send an id!");
        } else {
         if($reservation->deleteReservation($id)) {
             http_response_code(200); //OK
             $response = array("message" => "Reservation deleted");
         }
        }
        break;
}

//Skickar svar tillbaka till avsändaren
echo json_encode($response);