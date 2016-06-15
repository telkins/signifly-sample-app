<?php
namespace Application\Project;

use Application\Team\TeamService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class AddMembersFormFactory implements FactoryInterface
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
        // Get application to get mvc event to get project ID to eliminate current team members...
        $application = $container->get('Application');
        $projectId = $application->getMvcEvent()->getRouteMatch()->getParam('projectId');

        // Get services necessary to populate form...
        $teamService = $container->get(TeamService::class);

        // Instantiate form...
        $form = new AddMembersForm('add_members_form');

        // Get elements that need populating...
        $membersElement = $form->get(AddMembersForm::FIELD_NAME_MEMBERS);

        $currentTeam = $teamService->getTeamByProjectId($projectId);
        $currentTeam->buffer();

        // Populate members, including names, areas of expertise, and technologies...
        $members = $teamService->getAllMembers();
        $membersArray = [];
        foreach ($members as $member) {
            // Don't add to list if already a team member...
            if ($teamService->isMemberInTeam($member, $currentTeam)) {
                continue;
            }

            $memberInfo = $member->getLastName() . ', ' . $member->getFirstName() . ' (Expertise: ';

            $memberAreasOfExpertise = [];
            foreach ($member->getAreasOfExpertise() as $maoe) {
                $memberAreasOfExpertise[] = $maoe->getAreaOfExpertiseName();
            }

            if (empty($memberAreasOfExpertise)) {
                $memberInfo .= 'n/a';
            } else {
                $memberInfo .= implode(', ', $memberAreasOfExpertise);
            }
            $memberInfo .= ') (Tech: ';

            $memberTechnologies = [];
            foreach ($member->getTechnologies() as $tech) {
                $memberTechnologies[] = $tech->getTechnologyName();
            }

            if (empty($memberTechnologies)) {
                $memberInfo .= 'n/a';
            } else {
                $memberInfo .= implode(', ', $memberTechnologies);
            }
            $memberInfo .= ')';

            $membersArray[$member->getId()] = $memberInfo;
        }
        $membersElement->setValueOptions($membersArray);

        return $form;
    }
}
