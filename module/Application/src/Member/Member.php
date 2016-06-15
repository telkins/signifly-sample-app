<?php
namespace Application\Member;

class Member
{
    private $id;

    private $firstName;

    private $lastName;

    private $title;

    private $phone;

    private $email;

    private $profileImageUrl;

    private $yearsWithSignifly;

    private $areasOfExpertise;

    private $technologies;

    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id = $value;

        return $this;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($value)
    {
        $this->firstName = $value;

        return $this;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($value)
    {
        $this->lastName = $value;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($value)
    {
        $this->title = $value;

        return $this;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($value)
    {
        $this->phone = $value;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($value)
    {
        $this->email = $value;

        return $this;
    }

    public function getProfileImageUrl()
    {
        return $this->profileImageUrl;
    }

    public function setProfileImageUrl($value)
    {
        $this->profileImageUrl = $value;

        return $this;
    }

    public function getYearsWithSignifly()
    {
        return $this->yearsWithSignifly;
    }

    public function setYearsWithSignifly($value)
    {
        $this->yearsWithSignifly = $value;

        return $this;
    }

    public function getAreasOfExpertise()
    {
        return $this->areasOfExpertise;
    }

    public function setAreasOfExpertise($value)
    {
        $this->areasOfExpertise = $value;

        return $this;
    }

    public function getTechnologies()
    {
        return $this->technologies;
    }

    public function setTechnologies($value)
    {
        $this->technologies = $value;

        return $this;
    }
}