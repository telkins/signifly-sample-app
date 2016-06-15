<?php
namespace Application\Member\Expertise;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class MemberExpertiseService
{
    private $memberExpertiseTableGateway;

    public function __construct(TableGateway $memberExpertiseTableGateway)
    {
        $this->memberExpertiseTableGateway = $memberExpertiseTableGateway;
    }

    public function getByMemberId($memberId)
    {
        $resultSet = $this->memberExpertiseTableGateway->select(function (Select $select) use ($memberId) {
            $select->join(['aoe' => 'area_of_expertise'], 'aoe.id = member_expertise.area_of_expertise_id', ['area_of_expertise_name' => 'name']);
            $select->where->equalTo('member_id', $memberId);
        });

        return $resultSet;
    }
}
