<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Expertise\ExpertiseService;
use Application\Project\AddMembersForm;
use Application\Project\AddMembersInputFilter;
use Application\Project\Project;
use Application\Project\ProjectForm;
use Application\Project\ProjectHydrator;
use Application\Project\ProjectInputFilter;
use Application\Project\ProjectService;
use Application\Team\TeamService;
use Application\Technology\TechnologyService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ProjectsController extends AbstractActionController
{
    private $projectService;

    private $expertiseService;

    private $teamService;

    private $technologyService;

    private $projectForm;

    private $projectHydrator;

    private $addMembersForm;

    public function __construct(ProjectService $projectService, TeamService $teamService, ExpertiseService $expertiseService, TechnologyService $technologyService, ProjectForm $projectForm, ProjectHydrator $projectHydrator, AddMembersForm $addMembersForm)
    {
        $this->projectService = $projectService;
        $this->teamService = $teamService;
        $this->expertiseService = $expertiseService;
        $this->technologyService = $technologyService;
        $this->projectForm = $projectForm;
        $this->projectHydrator = $projectHydrator;
        $this->addMembersForm = $addMembersForm;
    }

    public function indexAction()
    {
        return new ViewModel([
            'projects' => $this->projectService->getAll(),
        ]);
    }

    public function newAction()
    {
        $form = $this->projectForm;

        $form->setAttribute('action', 'new');
        $form->get(ProjectForm::FIELD_NAME_SUBMIT)->setValue('Create');

        $viewModel = new ViewModel([
            'form' => $form,
        ]);

        // Pass in the route/url you want to redirect to after the POST
        $prg = $this->prg(); // Use current route to generate the URL for redirect

        if ($prg instanceof Response) {
            // returned a response to redirect us
            return $prg;
        } elseif ($prg === false) {
            /**
             * This wasn't a POST request, but there were no params in the
             * flash messenger. This is probably the first time the form was
             * loaded.
             */
            $form->get(ProjectForm::FIELD_NAME_AREAS_OF_EXPERTISE)->setValue([1]); // project management...

            $form->get(ProjectForm::FIELD_NAME_TECHNOLOGIES)->setValue([1, 2, 17, 20, 34]); // php, mysql, photoshop, angular, illustrator

            return $viewModel;
        }

        // $prg is an array containing the POST params from the previous request
        $form->setData($prg);

        // Start processing form...
        $form->setInputFilter(new ProjectInputFilter());
        if ($form->isValid()) {
            $project = new Project();

            $this->projectHydrator->hydrate($form->getData(), $project);

            $project = $this->projectService->saveProject($project);

            $areasOfExpertise = $form->get(ProjectForm::FIELD_NAME_AREAS_OF_EXPERTISE)->getValue();
            $technologies = $form->get(ProjectForm::FIELD_NAME_TECHNOLOGIES)->getValue();

            $this->teamService->generateTeam($project, $areasOfExpertise, $technologies);

            /**
             * Redirect to new project
             *
             * @todo Or should this redirect to projects index page...?
             */
            return $this->redirect()->toRoute('projects', ['action' => 'view', 'projectId' => $project->getId()]);
        }

        return $viewModel;
    }

    public function viewAction()
    {
        $projectId = $this->getEvent()->getRouteMatch()->getParam('projectId');
        $project = $this->projectService->getById($projectId);

        return new ViewModel([
            'project' => $project,
            'team' => $this->teamService->getTeam($project),
        ]);
    }

    public function removeAction()
    {
        $projectId = $this->getEvent()->getRouteMatch()->getParam('projectId');
        $project = $this->projectService->getById($projectId);

        $memberId = $this->getEvent()->getRouteMatch()->getParam('memberId');
        $member = $this->teamService->getMemberById($memberId);

        $this->teamService->removeTeamMember($project, $member);

        return $this->redirect()->toRoute('projects', ['action' => 'view', 'projectId' => $project->getId()]);
    }

    public function addMembersAction()
    {
        $form = $this->addMembersForm;

        // $form->setAttribute('action', 'new');
        $form->get(AddMembersForm::FIELD_NAME_SUBMIT)->setValue('Add');

        $viewModel = new ViewModel([
            'form' => $form,
        ]);

        // Pass in the route/url you want to redirect to after the POST
        $prg = $this->prg(); // Use current route to generate the URL for redirect

        if ($prg instanceof Response) {
            // returned a response to redirect us
            return $prg;
        } elseif ($prg === false) {
            /**
             * This wasn't a POST request, but there were no params in the
             * flash messenger. This is probably the first time the form was
             * loaded.
             */
            return $viewModel;
        }

        // $prg is an array containing the POST params from the previous request
        $form->setData($prg);

        // Start processing form...
        $form->setInputFilter(new AddMembersInputFilter());
        if ($form->isValid()) {
            $projectId = $this->getEvent()->getRouteMatch()->getParam('projectId');
            $project = $this->projectService->getById($projectId);

            $newMemberIds = $form->get(AddMembersForm::FIELD_NAME_MEMBERS)->getValue();

            $newMembers = $this->teamService->getMembersByIds($newMemberIds);

            $this->teamService->addTeamMembers($project, $newMembers);

            /**
             * Redirect to new project
             *
             * @todo Or should this redirect to projects index page...?
             */
            return $this->redirect()->toRoute('projects', ['action' => 'view', 'projectId' => $project->getId()]);
        }

        return $viewModel;
    }
}
