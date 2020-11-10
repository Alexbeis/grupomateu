<?php

namespace Mateu\Shared\Domain\ValueObject;

use Mateu\Shared\Domain\ValueObject\Validators\Validable;

class EmailAddress
{
    private $value;

    public function __construct($value, Validable $validator = null)
    {
        if (is_null($validator)) {
            $validator = new Validators\Email;
        }
        try {
            $validator->validate($value);
        } catch (\Exception $e) {
            throw new \Exception(sprintf("Value: %s is not a valid email address", $value));
        }

        $this->value = $value;
    }

    /**
     * Get Email Address
     * @return string
     */
    public function get()
    {
        return $this->value;
    }

    /**
     * Allow object to be echoed as string
     * @return string
     */
    public function __toString()
    {
        return $this->get();
    }

}