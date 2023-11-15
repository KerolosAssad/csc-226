<?php

class Artist
{
    private $conn;
    private $db_table = "Artist";
    public $counter;
    public $name;
    public $nationality;
    public $age;
    public $gender;
    public $DOB;
    public $alive;
    /**
     * @var false|string
     */
    public $DOD;
    public $FormalEducation;
    public $ArtMedium;

    /**
     * @param PDO|null $db
     */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createArtist()
    {
        $sqlQuery = "INSERT INTO
                    " . $this->db_table . "
                SET
                    name = :name, 
                    nationality = :nationality, 
                    age = :age, 
                    gender = :gender, 
                    DOB = :DOB, 
                    alive = :alive,
                    DOD= :DOD,
                    FormalEducation= :FormalEducation,
                    ArtMedium= :ArtMedium";
        $stmt = $this->conn->prepare($sqlQuery);

        // sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->nationality = htmlspecialchars(strip_tags($this->nationality));
        $this->age = htmlspecialchars(strip_tags($this->age));
        $this->gender = htmlspecialchars(strip_tags($this->gender));
        $this->DOB = htmlspecialchars(strip_tags($this->DOB));
        $this->alive = htmlspecialchars(strip_tags($this->alive));
        $this->DOD = htmlspecialchars(strip_tags($this->DOD));
        $this->FormalEducation = htmlspecialchars(strip_tags($this->FormalEducation));
        $this->ArtMedium = htmlspecialchars(strip_tags($this->ArtMedium));

        // bind data
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":nationality", $this->nationality);
        $stmt->bindParam(":age", $this->age);
        $stmt->bindParam(":gender", $this->gender);
        $stmt->bindParam(":DOB", $this->DOB);
        $stmt->bindParam(":alive", $this->alive);
        $stmt->bindParam(":DOD", $this->DOD); // Add this line
        $stmt->bindParam(":FormalEducation", $this->FormalEducation);
        $stmt->bindParam(":ArtMedium", $this->ArtMedium);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function deleteArtist()
    {
        // Ensure the counter property is set before attempting to delete
        if (!isset($this->counter)) {
            return false;
        }

        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE counter = :counter";
        $stmt = $this->conn->prepare($sqlQuery);

        // Bind the counter to the query
        $stmt->bindParam(":counter", $this->counter);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
    public function updateArtist()
    {
        if (!isset($this->counter)) {
            return false;
        }

        $sqlQuery = "UPDATE " . $this->db_table . " 
                     SET
                        name = :name,
                        nationality = :nationality,
                        age = :age,
                        gender = :gender,
                        DOB = :DOB,
                        alive = :alive,
                        DOD = :DOD,
                        FormalEducation = :FormalEducation,
                        ArtMedium = :ArtMedium
                     WHERE counter = :counter";

        $stmt = $this->conn->prepare($sqlQuery);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->nationality = htmlspecialchars(strip_tags($this->nationality));
        $this->age = htmlspecialchars(strip_tags($this->age));
        $this->gender = htmlspecialchars(strip_tags($this->gender));
        $this->DOB = htmlspecialchars(strip_tags($this->DOB));
        $this->alive = htmlspecialchars(strip_tags($this->alive));
        $this->DOD = htmlspecialchars(strip_tags($this->DOD));
        $this->FormalEducation = htmlspecialchars(strip_tags($this->FormalEducation));
        $this->ArtMedium = htmlspecialchars(strip_tags($this->ArtMedium));
        $this->counter = htmlspecialchars(strip_tags($this->counter));

        $stmt->bindParam(":counter", $this->counter);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":nationality", $this->nationality);
        $stmt->bindParam(":age", $this->age);
        $stmt->bindParam(":gender", $this->gender);
        $stmt->bindParam(":DOB", $this->DOB);
        $stmt->bindParam(":alive", $this->alive);
        $stmt->bindParam(":DOD", $this->DOD);
        $stmt->bindParam(":FormalEducation", $this->FormalEducation);
        $stmt->bindParam(":ArtMedium", $this->ArtMedium);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
    public function getArtists()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table;
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();

        return $stmt;
    }
    public function getSingleArtist()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . " WHERE counter = :counter LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->counter = htmlspecialchars(strip_tags($this->counter));
        $stmt->bindParam(":counter", $this->counter);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $stmt->bindParam(":counter", $this->counter);
            $this->name = $row['name'];
            $this->nationality = $row['nationality'];
            $this->age = $row['age'];
            $this->gender = $row['gender'];
            $this->DOB = $row['DOB'];
            $this->alive = $row['alive'];
            $this->DOD = $row['DOD'];
            $this->FormalEducation = $row['FormalEducation'];
            $this->ArtMedium = $row['ArtMedium'];
        }
    }
}
?>