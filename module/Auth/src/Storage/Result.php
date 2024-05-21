<?php

namespace Auth\Storage;

class Result 
{

    protected $message;
    
    const SUCCESS = 1;
    const FAILURE = 0;
    const FAILURE_IDENTITY_NOT_FOUND = -1;
    const FAILURE_IDENTITY_AMBIGUOUS = -2;
    const FAILURE_CREDENCIAL_INVALID = -3;
    const FAILURE_UNCATEGORIZED = -4;

    public function __construct($code, $indentity, array $messages = [
        0 => 'Operational Error',
        1 => 'Hi %s',
        -1 => 'Error: User not found',
        -2 => 'Operational Error',
        -3 => 'Invalid Password!',
        -4 => 'Operational Error',

    ]) 
    {
        if ($code === Result::SUCCESS) {
            $this->setMessage(sprintf($messages[$code], $indentity), 'success');
            # code...
        } elseif ($code === Result::FAILURE) {
                $this->setMessage($messages[$code], 'error');
        } elseif ($code < Result::FAILURE) {
            $this->setMessage($messages[$code], 'alert');
        }
    }

    public function getMessage() : String {
        return $this->message;
    }

    
    public function setMessage($message, $class) {
        $icon['success'] = 'ion-checkmark-round';
        $icon['info'] = 'ion-information-round';
        $icon['alert'] = 'ion-alert-round';
        $icon['error'] = 'ion-close-round';

        $this->message = sprintf("<div class='alert alert_%s'><span>%s<i class='icone %s'</i></span></div>", $class, $message);
    }

}