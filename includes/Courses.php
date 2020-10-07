<?php

// A Class instance named Courses is created
class Courses
{
    private $db;

    // Constructor connecting to the database is created
    function __construct()
    {

        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if ($this->db->connect_errno > 0) {
            die("Error with connection: " . $this->db->connect_error);
        } 
    }

    // a function names getCourses is created which gathers all rows and exports it as an array from table courses in database webbutveckling
    public function getCourses()
    {
        // SQL-fråga
        $sql = "SELECT * FROM courses";
        $result = $this->db->query($sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    // a function names getCourse which gathers the row matching the id from table courses in database webbutveckling and exports it as an array
    public function getCourse(int $id) {
        $sql = "SELECT * FROM courses WHERE id= '$id'";
        $result = $this->db->query($sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    // a function named addCourse which takes strings for each category in the table and inserts these into the table
    public function addCourse(string $coursecode, string $name, string $progression, string $coursesyllabus){
        $sql = "INSERT INTO courses(coursecode, name, progression, coursesyllabus) VALUES('$coursecode','$name', '$progression', '$coursesyllabus')";
        return $this->db->query($sql);
    }

    // a function named deleteCourse is tasked with deleting the course with the matching id 
    public function deleteCourse(int $id) {
        $sql = "DELETE FROM courses WHERE id= '$id'";
        return $this->db->query($sql);
    }

    // updateCourse is created which takes strings for each category and replaces this information with the course containing the matching id
    public function updateCourse(string $coursecode, string $name, string $progression, string $coursesyllabus, int $id){
        $sql = "UPDATE courses SET coursecode = '" . $coursecode ."' ,name = '" . $name . "',progression =  '" . $progression . "',coursesyllabus =  '" . $coursesyllabus . "' WHERE id= '$id'";
        return $this->db->query($sql);
    }
}