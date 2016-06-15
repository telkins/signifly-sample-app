<?php
namespace Application\Project;

use Zend\Filter\StringTrim;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Digits;

class ProjectInputFilter extends InputFilter
{
    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        $this->add([
            'name'     => ProjectForm::FIELD_NAME_ID,
            'required' => true,
            'filters'  => [
                [
                    'name' => ToInt::class,
                ],
            ],
            'validators' => [
                [
                    'name' => Digits::class,
                ],
            ],
        ]);

        $this->add([
            'name'     => ProjectForm::FIELD_NAME_NAME,
            'required' => true,
            'filters'  => [
                [
                    'name' => StringTrim::class,
                ],
            ],
        ]);

        $this->add([
            'name'     => ProjectForm::FIELD_NAME_AREAS_OF_EXPERTISE,
            'required' => false,
            'filters'  => [
                [
                    'name' => ToInt::class,
                ],
            ],
        ]);

        $this->add([
            'name'     => ProjectForm::FIELD_NAME_TECHNOLOGIES,
            'required' => false,
            'filters'  => [
                [
                    'name' => ToInt::class,
                ],
            ],
        ]);
    }
}
