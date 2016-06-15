<?php
namespace Application\Project;

use Application\Expertise\ExpertiseService;
use Application\Project\ProjectService;
use Application\Team\TeamService;
use Application\Technology\TechnologyService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ProjectFormFactory implements FactoryInterface
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
        $technologyService = $container->get(TechnologyService::class);

        // Instantiate form...
        $form = new ProjectForm('project_form');

        // Get elements that need populating...
        $technologiesElement = $form->get(ProjectForm::FIELD_NAME_TECHNOLOGIES);
        $areasOfExpertiseElement = $form->get(ProjectForm::FIELD_NAME_AREAS_OF_EXPERTISE);

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

        return $form;
    }
}
