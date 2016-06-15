<?php
namespace Application\Member\Technology;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class MemberTechnologyService
{
    private $memberTechnologyTableGateway;

    public function __construct(TableGateway $memberTechnologyTableGateway)
    {
        $this->memberTechnologyTableGateway = $memberTechnologyTableGateway;
    }

    public function getByMemberId($memberId)
    {
        $resultSet = $this->memberTechnologyTableGateway->select(function (Select $select) use ($memberId) {
            $select->join(['tech' => 'technology'], 'tech.id = member_technology.technology_id', ['technology_name' => 'name']);
            $select->where->equalTo('member_id', $memberId);
        });

        return $resultSet;
    }
}
