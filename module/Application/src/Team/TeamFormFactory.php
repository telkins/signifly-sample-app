<?php
namespace Application\Team;

use Application\Expertise\ExpertiseService;
use Application\Team\TeamService;
use Application\Technology\TechnologyService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class TeamFormFactory implements FactoryInterface
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
        // Get services necessary to populate form...
        $expertiseService = $container->get(ExpertiseService::class);
        $teamService = $container->get(TeamService::class);
        $technologyService = $container->get(TechnologyService::class);

        // Instantiate form...
        $form = new TeamForm('team_form');

        // Get elements that need populating...
        $technologiesElement = $form->get(TeamForm::FIELD_NAME_TECHNOLOGIES);
        $areasOfExpertiseElement = $form->get(TeamForm::FIELD_NAME_AREAS_OF_EXPERTISE);
        $membersElement = $form->get(TeamForm::FIELD_NAME_MEMBERS);

        // Populate technologies...
        $technologies = $technologyService->getAll();
        $technologiesArray = [];
        foreach ($technologies as $technology) {
            $technologiesArray[$technology->getId()] = $technology->getName();
        }
        $technologiesElement->setValueOptions($technologiesArray);

        // Populate areas of expertise...
        $areasOfExpertise = $expertiseService->getAll();
        $areasOfExpertiseArray = [];
        foreach ($areasOfExpertise as $areaOfExpertise) {
            $areasOfExpertiseArray[$areaOfExpertise->getId()] = $areaOfExpertise->getName();
        }
        $areasOfExpertiseElement->setValueOptions($areasOfExpertiseArray);

        // Populate members, including names, areas of expertise, and technologies...
        $members = $teamService->getAllMembers();
        $membersArray = [];
        foreach ($members as $member) {
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
