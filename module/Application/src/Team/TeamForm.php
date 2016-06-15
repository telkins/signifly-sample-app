<?php
namespace Application\Team;

use Zend\Form\Form;

class TeamForm extends Form
{
    const FIELD_NAME_ID                 = 'id';
    const FIELD_NAME_NAME               = 'name';
    const FIELD_NAME_AREAS_OF_EXPERTISE = 'areas_of_expertise';
    const FIELD_NAME_TECHNOLOGIES       = 'technologies';
    const FIELD_NAME_MEMBERS            = 'members';
    const FIELD_NAME_SUBMIT             = 'submit';

    public function __construct($name = null)
    {
        // We want to ignore the name passed...
        parent::__construct('team');

        $this->add([
            'name' => self::FIELD_NAME_ID,
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => self::FIELD_NAME_NAME,
            'type' => 'text',
            'options' => [
                'label' => 'Name',
            ],
        ]);
        $this->add([
            'name' => self::FIELD_NAME_AREAS_OF_EXPERTISE,
            'type' => 'select',
            'options' => [
                'label' => 'Areas of Expertise',
            ],
            'attributes' => [
                'multiple' => true,
            ],
        ]);
        $this->add([
            'name' => self::FIELD_NAME_TECHNOLOGIES,
            'type' => 'select',
            'options' => [
                'label' => 'Technologies',
            ],
            'attributes' => [
                'multiple' => true,
            ],
        ]);
        $this->add([
            'name' => self::FIELD_NAME_MEMBERS,
            'type' => 'select',
            'options' => [
                'label' => 'Members',
            ],
            'attributes' => [
                'multiple' => true,
            ],
        ]);
        $this->add([
            'name' => self::FIELD_NAME_SUBMIT,
            'type' => 'submit',
            'attributes' => [
                'value' => 'Create',
            ],
        ]);
    }
}
