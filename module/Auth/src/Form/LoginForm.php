<?php

namespace Auth\Form;

use Interop\Container\ContainerInterface;
use Zend\Form\Form;
use Zend\Form\Element;

class LoginForm extends Form {

    public function __construct(ContainerInterface $containerInterface, $name = 'Login',  array $options=[])
    {
        //$this->containerInterface = $containerInterface;
        parent::__construct($name, $options);
        $this->setInputFilter($containerInterface->get(LoginFilter::class));

        $this->add([
            'name' => 'email',
            'type' => 'email',
            'options' => [
                'label' => 'Email',
            ],
            'attributes' => [
                'id' => 'email',
                'class' => 'form-control',
                'required' => true,
            ],
        ]);
        $this->add([
            'name' => 'password',
            'type' => 'password',
            'options' => [
                'label' => 'Password',
            ],
            'attributes' => [
                'id' => 'password',
                'class' => 'form-control',
                'required' => true,
            ],
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);
    }
}
