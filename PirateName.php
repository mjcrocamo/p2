<?php
namespace P2Pirate;

class PirateName
{

    # Properties

    private $names;



    #Methods

    public function __construct($json)
    {
        # Load json name data
        $namesJson = file_get_contents($json);
        $this->names = json_decode($namesJson, true);
    }

    # Index into JSON and match to a name based on user data
    public function getPirateName(String $firstNameLetter, String $month, String $lastNameLetter)
    {
        # Initialize array to store pirate name
        $newPirateName = [];

        # Generate name according to what the user submitted
        foreach($this->names as $jsonLabel => $name) {
            foreach($name as $key => $pirateName) {
                if($jsonLabel == "FirstName") {
                    if($key == $firstNameLetter) {
                        $newPirateName["first"] = $pirateName;
                    }
                } else if($jsonLabel == "Birthday") {
                    if($key == $month) {
                        $newPirateName["middle"] = $pirateName;
                    }
                } else {
                    if($key == $lastNameLetter) {
                        $newPirateName["last"] = $pirateName;
                    }
                }
            }
        }
        return $newPirateName;
    }

}