<?php

class Artist
{
    private $db_table = "Artist";
    public $counter;
    public $name;
    public $nationality;
    public $age;
    public $gender;
    public $DOB;
    public $status;
    /**
     * @var false|string
     */
    public $DOD;
    public $FormalEducation;
    public $ArtMedium;

    /**
     * @param PDO|null $db
     */
    public function __construct(\PDO $db)
    {
    }

    public function createArtist(){
        $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        counter= :counter,
                        name = :name, 
                        nationality = :nationality, 
                        age = :age, 
                        gender = :gender, 
                        DOB = :DOB, 
                        status = :status,
                        DOD= :DOD,
                        FormalEducation= :FormalEducation,
                        ArtMedium= :ArtMedium";
        $stmt = $this->conn->prepare($sqlQuery);

        // sanitize
        $this->counter =htmlspecialchars(strip_tags( $this->counter));
        $this->name =htmlspecialchars(strip_tags($this->name));
        $this->nationality =htmlspecialchars(strip_tags($this->nationality));
        $this->age = htmlspecialchars(strip_tags($this->age));
        $this->gender = htmlspecialchars(strip_tags( $this->gender));
        $this->DOB = htmlspecialchars(strip_tags($this->DOB));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->DOD = htmlspecialchars(strip_tags($this->DOD));;
        $this->FormalEducation = htmlspecialchars(strip_tags($this->FormalEducation));
        $this->ArtMedium = htmlspecialchars(strip_tags($this->ArtMedium));

        // bind data
        $stmt->bindParam("counter:", $this->counter);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":nationality", $this->nationality);
        $stmt->bindParam(":age", $this->age);
        $stmt->bindParam(":gender", $this->gender);
        $stmt->bindParam(":DOB", $this->DOB);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":DOB", $this->DOD);
        $stmt->bindParam(":FormalEducation", $this->FormalEducation);
        $stmt->bindParam(":ArtMedium", $this->ArtMedium);

        if($stmt->execute()){
            return true;
        }
        return false;
    }
}