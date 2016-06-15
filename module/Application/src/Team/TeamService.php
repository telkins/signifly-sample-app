<?php
namespace Application\Team;

use Application\Member\Member;
use Application\Project\Project;
use Zend\Db\ResultSet\ResultSetInterface;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class TeamService
{
    private $memberTableGateway;

    private $teamTableGateway;

    public function __construct(TableGateway $memberTableGateway, TableGateway $teamTableGateway)
    {
        $this->memberTableGateway = $memberTableGateway;
        $this->teamTableGateway = $teamTableGateway;
    }

    public function getAllMembers()
    {
        $resultSet = $this->memberTableGateway->select(function (Select $select) {
            $select->order('last_name, first_name ASC');
        });

        return $resultSet;
    }

    public function getMemberById($id)
    {
        $resultSet = $this->memberTableGateway->select(function (Select $select) use ($id) {
            $select->where->equalTo('id', $id);
        });

        return $resultSet->current();
    }

    public function getMembersByIds(array $ids)
    {
        if (empty($ids)) {
            $ids = [0];
        }

        $resultSet = $this->memberTableGateway->select(function (Select $select) use ($ids) {
            $select->where->in('id', $ids);
        });

        return $resultSet;
    }

    public function getTeam(Project $project)
    {
        return $this->getTeamByProjectId($project->getId());
    }

    public function getTeamByProjectId($projectId)
    {
        $resultSet = $this->memberTableGateway->select(function (Select $select) use ($projectId) {
            $select->join(['pm' => 'project_member'], 'pm.member_id = member.id', [])
                ->where->equalTo('pm.project_id', $projectId);
            $select->order('last_name, first_name ASC');
        });

        return $resultSet;
    }

    public function getMembersBySpecs(array $areaOfExpertiseIds, array $technologyIds)
    {
        // First, get all members that match *any* criteria...
        if (empty($areaOfExpertiseIds)) {
            $areaOfExpertiseIds = [0];
        }

        if (empty($technologyIds)) {
            $technologyIds = [0];
        }

        $matchingMembers = $this->memberTableGateway->select(function (Select $select) use ($areaOfExpertiseIds, $technologyIds) {
            $select->quantifier(Select::QUANTIFIER_DISTINCT)
                ->join(['me' => 'member_expertise'], 'me.member_id = member.id', [], Select::JOIN_LEFT)
                ->join(['mt' => 'member_technology'], 'mt.member_id = member.id', [], Select::JOIN_LEFT)
                ->where->in('me.area_of_expertise_id', $areaOfExpertiseIds)
                    ->or->in('mt.technology_id', $technologyIds);
            $select->order('last_name, first_name ASC');
        });

        $matchingMembers->buffer();

        // Now, go through and assign each member a "weight"...
        $weightedMembers = [];
        foreach ($matchingMembers as $member) {
            $weight = $this->getMemberWeight($member, $areaOfExpertiseIds, $technologyIds);
            $weightedMembers[$weight][] = $member;
        }
        krsort($weightedMembers);

        // Now, go through weighted member list from heaviest to lightest...
        $team = [];
        foreach ($weightedMembers as $weight => $members) {
            foreach ($members as $member) {
                $match = false;

                // Remove matching areas of expertise from list...
                $aoes = $member->getAreasOfExpertise();
                foreach ($aoes as $aoe) {
                    $aoeId = $aoe->getAreaOfExpertiseId();
                    if (in_array($aoeId, $areaOfExpertiseIds)) {
                        $match = true;
                        unset($areaOfExpertiseIds[array_search($aoeId, $areaOfExpertiseIds)]);
                    }
                }

                // Remove matching technologies from list...
                $techs = $member->getTechnologies();
                foreach ($techs as $tech) {
                    $techId = $tech->getTechnologyId();
                    if (in_array($techId, $technologyIds)) {
                        $match = true;
                        unset($technologyIds[array_search($techId, $technologyIds)]);
                    }
                }
                // Only add the member to the team if he/she has qualifying expertise/technology...
                if ($match) {
                    $team[] = $member;
                }

                // When no more, then we've got our team...
                if (empty($areaOfExpertiseIds) && empty($technologyIds)) {
                    break 2;
                }
            }
        }
        return $team;
    }

    public function addTeamMember(Project $project, Member $member)
    {
        try {
            if (1 !== $this->teamTableGateway->insert(['project_id' => $project->getId(), 'member_id' => $member->getId()])) {
                throw new RuntimeException('Error adding team member to data store');
            }
        } catch (Exception $e) {
            throw new RuntimeException('Exception: ' . $e->getMessage());
        }
    }

    public function removeTeamMember(Project $project, Member $member)
    {
        try {
            if (1 !== $this->teamTableGateway->delete(['project_id' => $project->getId(), 'member_id' => $member->getId()])) {
                throw new RuntimeException('Error removing team member from data store');
            }
        } catch (Exception $e) {
            throw new RuntimeException('Exception: ' . $e->getMessage());
        }
    }

    public function addTeamMembers(Project $project, ResultSetInterface $members)
    {
        $currentTeam = $this->getTeam($project);
        $currentTeam->buffer();

        foreach ($members as $member) {
            if (!$this->isMemberInTeam($member, $currentTeam)) {
                $this->addTeamMember($project, $member);
            }
        }
    }

    public function isMemberInTeam(Member $candidate, ResultSetInterface $team)
    {
        $isInTeam = false;
        foreach ($team as $teamMember) {
            if ($candidate->getId() === $teamMember->getId()) {
                $isInTeam = true;
                break;
            }
        }

        return $isInTeam;
    }

    public function generateTeam(Project $project, array $areasOfExpertise, array $technologies)
    {
        $initialTeam = $this->getMembersBySpecs($areasOfExpertise, $technologies);

        foreach ($initialTeam as $member) {
            $this->addTeamMember($project, $member);
        }
    }

    /**
     * Determine a member's "weight".
     *
     * Arbitrary weight calculation is sum of following:
     *  - (tech1 proficiency1)^2 + (tech2 proficiency2)^2 ...
     *  - (aoe1 proficiency1)^2 + (aoe2 proficiency2)^2 ...
     *  - years with signifly
     */
    public function getMemberWeight(Member $member, array $areaOfExpertiseIds, array $technologyIds)
    {
        $techWeight = 0;
        $memberTechs = $member->getTechnologies();
        foreach ($memberTechs as $tech) {
            if (in_array($tech->getTechnologyId(), $technologyIds)) {
                $techWeight += ($tech->getProficiency() ** 2);
            }
        }

        $aoeWeight = 0;
        $memberExpertise = $member->getAreasOfExpertise();
        foreach ($memberExpertise as $aoe) {
            if (in_array($aoe->getAreaOfExpertiseId(), $areaOfExpertiseIds)) {
                $aoeWeight += ($aoe->getProficiency() ** 2);
            }
        }

        return ($techWeight + $aoeWeight + $member->getYearsWithSignifly());
    }
}
