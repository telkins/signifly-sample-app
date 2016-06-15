<?php
namespace Application\Project;

use Zend\Filter\StringTrim;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Digits;

class AddMembersInputFilter extends InputFilter
{
    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        $this->add([
            'name'     => AddMembersForm::FIELD_NAME_MEMBERS,
            'required' => true,
            'filters'  => [
                [
                    'name' => ToInt::class,
                ],
            ],
            'allow_empty' => false,
        ]);
    }
}
