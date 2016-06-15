<?php
namespace Application\Member\Expertise;

class MemberExpertise
{
    private $id;

    private $memberId;

    private $areaOfExpertiseId;

    private $areaOfExpertiseName;

    private $proficiency;

    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id = $value;

        return $this;
    }

    public function getMemberId()
    {
        return $this->memberId;
    }

    public function setMemberId($value)
    {
        $this->memberId = $value;

        return $this;
    }

    public function getAreaOfExpertiseId()
    {
        return $this->areaOfExpertiseId;
    }

    public function setAreaOfExpertiseId($value)
    {
        $this->areaOfExpertiseId = $value;

        return $this;
    }

    public function getAreaOfExpertiseName()
    {
        return $this->areaOfExpertiseName;
    }

    public function setAreaOfExpertiseName($value)
    {
        $this->areaOfExpertiseName = $value;

        return $this;
    }

    public function getProficiency()
    {
        return $this->proficiency;
    }

    public function setProficiency($value)
    {
        $this->proficiency = $value;

        return $this;
    }
}
