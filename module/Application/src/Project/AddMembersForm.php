<?php
namespace Application\Project;

use Zend\Form\Form;

class AddMembersForm extends Form
{
    const FIELD_NAME_MEMBERS = 'members';
    const FIELD_NAME_SUBMIT  = 'submit';

    public function __construct($name = null)
    {
        // We want to ignore the name passed...
        parent::__construct('add_members');

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
                'value' => 'Add',
            ],
        ]);
    }
}
