<?php
namespace Application\Project;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Hydrator\HydratorInterface;
use Exception;
use RuntimeException;

class ProjectService
{
    private $projectTableGateway;

    private $hydrator;

    public function __construct(TableGateway $projectTableGateway, HydratorInterface $hydrator)
    {
        $this->projectTableGateway = $projectTableGateway;
        $this->hydrator = $hydrator;
    }

    public function getAll()
    {
        $resultSet = $this->projectTableGateway->select(function (Select $select) {
            $select->order('name ASC');
        });

        return $resultSet;
    }

    public function saveProject(Project $project)
    {
        try {
            if (1 !== $this->projectTableGateway->insert($this->hydrator->extract($project))) {
                throw new RuntimeException('Error inserting new project to data store');
            }
            $project->setId($this->projectTableGateway->getLastInsertValue());

            return $project;
        } catch (Exception $e) {
            throw new RuntimeException('Exception: ' . $e->getMessage());
        }
    }

    public function getById($id)
    {
        $resultSet = $this->projectTableGateway->select(function (Select $select) use ($id) {
            $select->where->equalTo('id', $id);
        });

        return $resultSet->current();
    }
}
