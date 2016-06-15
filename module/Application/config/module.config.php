<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Expertise\ExpertiseHydrator;
use Application\Expertise\ExpertiseService;
use Application\Expertise\ExpertiseServiceFactory;
use Application\Member\Expertise\MemberExpertiseHydrator;
use Application\Member\Expertise\MemberExpertiseService;
use Application\Member\Expertise\MemberExpertiseServiceFactory;
use Application\Member\Technology\MemberTechnologyHydrator;
use Application\Member\Technology\MemberTechnologyService;
use Application\Member\Technology\MemberTechnologyServiceFactory;
use Application\Member\MemberHydrator;
use Application\Member\MemberHydratorFactory;
use Application\Project\AddMembersForm;
use Application\Project\AddMembersFormFactory;
use Application\Project\ProjectForm;
use Application\Project\ProjectFormFactory;
use Application\Project\ProjectHydrator;
use Application\Project\ProjectService;
use Application\Project\ProjectServiceFactory;
use Application\Team\TeamForm;
use Application\Team\TeamFormFactory;
use Application\Team\TeamService;
use Application\Team\TeamServiceFactory;
use Application\Technology\TechnologyHydrator;
use Application\Technology\TechnologyService;
use Application\Technology\TechnologyServiceFactory;
use Interop\Container\ContainerInterface;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller'    => Controller\IndexController::class,
                        'action'        => 'index',
                    ],
                ],
            ],
            'projects' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/projects[/:action[/:projectId[/:memberId]]]',
                    'defaults' => [
                        'controller'    => Controller\ProjectsController::class,
                        'action'        => 'index',
                    ],
                    'constraints' => [
                        'projectId' => '\d+',
                        'memberId' => '\d+',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
            Controller\ProjectsController::class => function(ContainerInterface $container, $requestedName) {
                $projectService = $container->get(ProjectService::class);
                $teamService = $container->get(TeamService::class);
                $expertiseService = $container->get(ExpertiseService::class);
                $technologyService = $container->get(TechnologyService::class);
                $projectForm = $container->get(ProjectForm::class);
                $projectHydrator = $container->get(ProjectHydrator::class);
                $addMembersForm = $container->get(AddMembersForm::class);

                return new Controller\ProjectsController($projectService, $teamService, $expertiseService, $technologyService, $projectForm, $projectHydrator, $addMembersForm);
            },
            Controller\TeamsController::class => function(ContainerInterface $container, $requestedName) {
                $teamService = $container->get(TeamService::class);
                $expertiseService = $container->get(ExpertiseService::class);
                $technologyService = $container->get(TechnologyService::class);
                $teamForm = $container->get(TeamForm::class);

                return new Controller\TeamsController($teamService, $expertiseService, $technologyService, $teamForm);
            },
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'application/teams/index' => __DIR__ . '/../view/application/teams/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
     'service_manager' => [
         'factories' => [
             ExpertiseHydrator::class => InvokableFactory::class,
             ExpertiseService::class => ExpertiseServiceFactory::class,
             MemberExpertiseHydrator::class => InvokableFactory::class,
             MemberExpertiseService::class => MemberExpertiseServiceFactory::class,
             MemberTechnologyHydrator::class => InvokableFactory::class,
             MemberTechnologyService::class => MemberTechnologyServiceFactory::class,
             MemberHydrator::class => MemberHydratorFactory::class,
             AddMembersForm::class => AddMembersFormFactory::class,
             ProjectForm::class => ProjectFormFactory::class,
             ProjectHydrator::class => InvokableFactory::class,
             ProjectService::class => ProjectServiceFactory::class,
             TeamForm::class => TeamFormFactory::class,
             TeamService::class => TeamServiceFactory::class,
             TechnologyHydrator::class => InvokableFactory::class,
             TechnologyService::class => TechnologyServiceFactory::class,
         ],
     ],
];
