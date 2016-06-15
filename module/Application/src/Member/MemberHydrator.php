<?php
namespace Application\Member;

use Application\Member\Expertise\MemberExpertiseService;
use Application\Member\Technology\MemberTechnologyService;
use Application\Member\Member;
use Zend\Hydrator\ClassMethods;
use Exception\InvalidArgumentException;

class MemberHydrator extends ClassMethods
{
    protected $memberExpertiseService = null;

    protected $memberTechnologyService = null;

    /**
     * Define if extract values will use camel case or name with underscore
     * 
     * @param boolean $underscoreSeparatedKeys
     */
    public function __construct(MemberExpertiseService $memberExpertiseService, MemberTechnologyService $memberTechnologyService, $underscoreSeparatedKeys = true)
    {
        parent::__construct($underscoreSeparatedKeys);

        $this->memberExpertiseService = $memberExpertiseService;
        $this->memberTechnologyService = $memberTechnologyService;
    }

    /**
     * Extract values from an object
     *
     * @param  Application\Member\Member $object
     * @return array
     * @throws Exception\InvalidArgumentException
     */
    public function extract($object)
    {
        if (!$object instanceof Member) {
            throw new InvalidArgumentException('$object must be an instance of ' . Member::class);
        }

        /**
         * @var $object Application\Member\Member
         */
        $data = parent::extract($object);

        return $data;
    }

    /**
     * Hydrate $object with the provided $data.
     *
     * @param  array $data
     * @param  object $object
     * @return MemberInterface
     * @throws Exception\InvalidArgumentException
     */
    public function hydrate(array $data, $object)
    {
        if (!$object instanceof Member) {
            throw new InvalidArgumentException('$object must be an instance of ' . Member::class);
        }

        $memberExpertise = $this->memberExpertiseService->getByMemberId($data['id']);
        $memberExpertise->buffer();

        $object->setAreasOfExpertise($memberExpertise);

        $memberTechnology = $this->memberTechnologyService->getByMemberId($data['id']);
        $memberTechnology->buffer();

        $object->setTechnologies($memberTechnology);

        return parent::hydrate($data, $object);
    }
}
