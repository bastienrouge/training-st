<?php

namespace App\Contact;

use Symfony\Component\Validator\Constraints as Assert;

class ContactData
{

    /**
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Email
     */
    public $email;

    public $subject;

    /**
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Length(min="5", max="255")
     */
    public $message;

}
