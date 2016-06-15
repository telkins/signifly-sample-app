<?php
namespace Application\Team;

use Application\Member\Member;
use Application\Member\MemberHydrator;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\Factory\FactoryInterface;

class TeamServiceFactory implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     * @param  null|array         $options
     * @return object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /**
         * @var $dbAdapter Zend\Db\Adapter\AdapterInterface
         */
        $dbAdapter = $container->get(Adapter::class);

        /**
         * @var $hydrator Zend\Hydrator\HydratorInterface
         */
        $hydrator = $container->get(MemberHydrator::class);

        /**
         * @var $resultSetPrototype Zend\Db\ResultSet\HydratingResultSet
         */
        $resultSetPrototype = new HydratingResultSet($hydrator, new Member());

        /**
         * @var $memberTableGateway Zend\Db\TableGateway\TableGateway
         */
        $memberTableGateway = new TableGateway('member', $dbAdapter, null, $resultSetPrototype);

        /**
         * @var $teamTableGateway Zend\Db\TableGateway\TableGateway
         */
        $teamTableGateway = new TableGateway('project_member', $dbAdapter);

        return new TeamService($memberTableGateway, $teamTableGateway);
    }
}
