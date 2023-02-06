# projekt_webservice_vt22-llisora
projekt_webservice_vt22-llisora created by GitHub Classroom

<h1>DT173G - projekt i kursen webbutveckling III </h1> <br>
Detta repository innehåller 3 olika api - en för bokning, en för meny samt en för användare. <br>
Detta är del 1 av 3 i projektuppgiften för Webbutveckling III - mittuniversitetet Sundsvall. <br>
<br>

<h1>Installation - databas</h1>
För att installera databasen så kör man install.php. Man kan även lägga till tabellerna direkt i phpmyadmin. <br>
Här är tabellerna ifall man väljer att göra det, då jag har haft en del problem med att få installscriptet att installera korrekt: <br>

<h2>Food</h2>
CREATE TABLE food( <br>
    id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,<br>
    name VARCHAR(128) NOT NULL,<br>
    description TEXT NOT NULL,<br>
    price INT(11) NOT NULL,<br>
    type VARCHAR (128),<br>
    categoryname INT(11) NOT NULL<br>
);<br>

<h2>Booking</h2>
CREATE TABLE booking (<br>
    id int(11) NOT NULL,<br>
    name varchar(128) NOT NULL,<br>
    time varchar(156) NOT NULL,<br>
    date varchar(128) NOT NULL,<br>
    quantity int(11) NOT NULL<br>
);<br>

<h2>Users</h2>
CREATE TABLE users (<br>
    id int(11) NOT NULL,<br>
    username varchar(128) NOT NULL,<br>
    password varchar(156) NOT NULL<br>
);<br>

<h1>Klasser och metoder</h1>
<h2>Booking</h2> <br>
<b>Properties</b> <br>
<ul>
  <li> private $id; - unikt ID</li>
  <li> private $name; - namn på person</li>
  <li>  private $time; - tid för bokning</li>
  <li>private $date; - datum för bokning</li>
  <li> private $quantity; - antal personer</li>
  <li> private $db; - databasanslutning</li> 
  </ul>
    
  <b>Metoder</b> <br>
  <ul>
<li>Constructor - skapar databasanslutning. </li>
<li>getReservation - array : Hämtar in alla bokningar. </li>
  <li>getReservationById - array : Hämtar bokning via id. </li>
  <li>setReservation (string $name, string $time, string $date, int $quantity) - bool : set-metod för bokningar. </li>
  <li>setReservationAndId (int $id, string $name, string $time, string $date, int $quantity) - bool : set-metod för bokning med speciellt id. </li>
  <li>createReservation - bool : skapar bokning genom att sätta in data i databasen. </li>
 <li> updateReservation - bool : metod för att uppdatera bokning. </li>
  <li>deleteReservation (int $id) - bool : metod för att radera bokning. </li>
  </ul>
  
  <h2>Food</h2>
  <b>Properties</b> <br>
<ul>
  <li> private $id; - unikt ID</li>
  <li> private $name; - namn på maträtt/dryck</li>
  <li>  private $description; - beskrivande text om maträtt/dryck</li>
  <li>private $price; - pris</li>
  <li> private $category; - kategori (förrätt, varmrätt, efterrätt)</li>
  <li> private $db; - databasanslutning</li> 
</ul>
  
   <b> Metoder</b>
  <ul>
<li>Constructor - skapar databasanslutning. </li>
<li>getFood - array : Hämtar in meny. </li>
  <li>getFoodById - array : Hämtar dryck/maträtt via id. </li>
  <li>setFood (string $name, string $description, string $price, string $category) - bool : set-metod för menyn. </li>
  <li>setFoodnAndId (int $id, string $name, string $description, string $price, string $category) - bool : set-metod för maträtt/dryck med speciellt id. </li>
  <li>createFood - bool : skapar maträtt/dryck genom att sätta in data i databasen. </li>
 <li> updateFood - bool : metod för att uppdatera meny. </li>
  <li>deleteFood (int $id) - bool : metod för att radera från menyn. </li>
  </ul>
  
  
  <h2>Login</h2>
    <b>Properties</b> <br>
<ul>
  <li> private $username; - namn på användare</li>
  <li>  private $password; - lösenord till admin</li>
  <li> private $db; - databasanslutning</li>
</ul>
  
<b>Metoder</b> <br>
<ul>
     <li>setUser (string $username, string $password) - set-metod för användare. </li>
     <li>loginUser ($username, $password): bool - metod för att logga in användare. </li>
<ul>
     
<h1>Användning meny/booking-api</h1><br>
(de fungerar likadant så skriv bara menuapi eller bookingapi beroende på vilken du vill använda)
  
<table>
<thead>
<tr>
<th>Metod</th>
<th>Ändpunkt</th>
<th>Beskrivning</th>
</tr>
</thead>
<tbody>
<tr>
<td>GET</td>
<td>/api.php</td>
<td>Hämtar all data som finns i databasen (hela menyn eller alla bokningar).</td>
</tr>
<tr>
<td>GET</td>
<td>/api.php?=ID]</td>
<td>Hämtar en specifik bokning och/eller maträtt/dryck med angivet ID.</td>
</tr>
<tr>
<td>POST</td>
<td>/api.php</td>
<td>Lagrar ny data. Kräver att ett objekt skickas med, dvs antingen en ny maträtt/dryck eller ny bokning.</td>
</tr>
<tr>
<td>PUT</td>
<td>/api.php?=ID</td>
<td>Uppdaterar en existerande maträtt/dryck eller bokning med angivet ID. Kräver att ett objekt skickas med, dvs antingen en ny maträtt/dryck eller ny bokning.</td>
</tr>
<tr>
<td>DELETE</td>
<td>/api.php?=ID</td>
<td>Raderar en maträtt/dryck eller bokning med angivet ID.</td>
</tr>
</tbody>
</table>
  
  Loginapi har <b>endast</b> stöd för post. <br>
  
  <h1>Menu</h1>
  
  Ett meny-objekt returneras/skickas som JSON med följande struktur:
  
    {
    "id": "8",
    "name": "Vitlöksbröd",
    "description": "med aioli",
    "price": "49",
    "category": "Förrätt"
  
  
  
  <h1>Booking</h1>
   Ett boknings-objekt returneras/skickas som JSON med följande struktur:
  
    {
    "id": "1",
    "name": "Lisa Bäcklin",
    "time": "19:00",
    "date": "2022-06-11",
    "quantity": "3"
  
  
