<?php
namespace Application\Technology;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class TechnologyService
{
    private $technologyTableGateway;

    public function __construct(TableGateway $technologyTableGateway)
    {
        $this->technologyTableGateway = $technologyTableGateway;
    }

    public function getAll()
    {
        $resultSet = $this->technologyTableGateway->select(function (Select $select) {
            $select->order('name ASC');
        });

        return $resultSet;
    }
}
