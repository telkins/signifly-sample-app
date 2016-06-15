<?php
namespace Application\Expertise;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class ExpertiseService
{
    private $expertiseTableGateway;

    public function __construct(TableGateway $expertiseTableGateway)
    {
        $this->expertiseTableGateway = $expertiseTableGateway;
    }

    public function getAll()
    {
        $resultSet = $this->expertiseTableGateway->select(function (Select $select) {
            $select->order('name ASC');
        });

        return $resultSet;
    }
}
