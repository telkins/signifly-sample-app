<?php
namespace Application\Member\Expertise;

use Application\Member\Expertise\MemberExpertise;
use Application\Member\Expertise\MemberExpertiseHydrator;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\Factory\FactoryInterface;

class MemberExpertiseServiceFactory implements FactoryInterface
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
        $hydrator = $container->get(MemberExpertiseHydrator::class);

        /**
         * @var $resultSetPrototype Zend\Db\ResultSet\HydratingResultSet
         */
        $resultSetPrototype = new HydratingResultSet($hydrator, new MemberExpertise());

        /**
         * @var $tableGateway Zend\Db\TableGateway\TableGateway
         */
        $tableGateway = new TableGateway('member_expertise', $dbAdapter, null, $resultSetPrototype);

        return new MemberExpertiseService($tableGateway);
    }
}
