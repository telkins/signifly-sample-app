<?php
namespace Application\Member;

use Application\Member\Expertise\MemberExpertiseService;
use Application\Member\Technology\MemberTechnologyService;
use Application\Member\Member;
use Application\Member\MemberHydrator;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\Factory\FactoryInterface;

class MemberHydratorFactory implements FactoryInterface
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
        $memberExpertiseService = $container->get(MemberExpertiseService::class);
        $memberTechnologyService = $container->get(MemberTechnologyService::class);

        return new MemberHydrator($memberExpertiseService, $memberTechnologyService);
    }
}
