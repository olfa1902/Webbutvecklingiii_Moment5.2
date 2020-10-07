<?php
// Including external files from includes folder
require 'includes/config.php';
require 'includes/Courses.php';

// Headers to allow for requests to the web service from all domains
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$method = $_SERVER['REQUEST_METHOD'];

// If id is set and available from the URL
if(isset($_GET['id'])) {
    $id = $_GET['id'];
}

// Code to start connection with database
/*$database = new Database();
$db = $database->connect();*/
$db = mysqli_connect(DBHOST,DBUSER,DBPASS,DBDATABASE) or die('Something went wrong with the connection to the database...');
//$db = new Database();
$courses = new Courses($db);


// Creates instance of class to send sql-questions to database
// Sends databaseconnection as a parameter

switch($method){
    case 'GET':
        if(isset($id)) {
            $result = $courses->getCourse($id);
            // Run function to read row with specific id
            //$result = $courses->readOne($id);
        } else{
            // Run function to read all data from database
            $result = $courses->getCourses();
        }

        // Controlling if result contains any rows
        if(count($result) > 0) {
            http_response_code(200); //Ok
        } else{
            http_response_code(404); //Not found
            $result = array("message" => "No courses found");
        }
    break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));

        //Removes tags and creates special characters to store and send to the class properties
        $courses->coursecode = $data->coursecode;
        $courses->name = $data->name;
        $courses->progression = $data->progression;
        $courses->coursesyllabus = $data->coursesyllabus;

        //Run function to create row
        if($courses->addCourse($data->coursecode,$data->name,$data->progression,$data->coursesyllabus)) {
            http_response_code(201); // Created
            $result = array("message" => "Course created");
        } else{
            http_response_code(503); // Server error
            $result = array("message" => "Course not created");
        }
    break;
    case 'PUT':
        // If no id is included, send an error
        if(!isset($id)) {
            http_response_code(510);
            $result = array("message" => "No id is sent");
        // If id is sent
        } else{
            $data = json_decode(file_get_contents("php://input"));

        //Removes tags and creates special characters to store and send to the class properties
        $courses->coursecode = $data->coursecode;
        $courses->name = $data->name;
        $courses->progression = $data->progression;
        $courses->coursesyllabus = $data->coursesyllabus;

        //Run function to update row
        if($courses->updateCourse($data->coursecode,$data->name,$data->progression,$data->coursesyllabus, $id)) {
            http_response_code(200); // OK
            $result = array("message" => "Courses updated");
        } else{
            http_response_code(503); // Server error
            $result = array("message" => "Course not updated");
        }

    }
    break;
    case 'DELETE':
        // If no id is included, send an error
        if(!isset($id)) {
            http_response_code(510);
            $result = array("message" => "No id is sent");
        // If id is sent
    } else{
        //Run function to update row
        if($courses->deleteCourse($id)) {
            http_response_code(200); // OK
            $result = array("message" => "Courses deleted");
        } else{
            http_response_code(503); // Server error
            $result = array("message" => "Course not deleted");
        }
    }
    break;
}

// Return result as JSON
echo json_encode($result);

// Close database connection
$db->close();
?>