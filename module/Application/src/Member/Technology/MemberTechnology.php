<?php
namespace Application\Member\Technology;

class MemberTechnology
{
    private $id;

    private $memberId;

    private $technologyId;

    private $technologyName;

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

    public function getTechnologyId()
    {
        return $this->technologyId;
    }

    public function setTechnologyId($value)
    {
        $this->technologyId = $value;

        return $this;
    }

    public function getTechnologyName()
    {
        return $this->technologyName;
    }

    public function setTechnologyName($value)
    {
        $this->technologyName = $value;

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
