<?php

namespace App\Exceptions;

use InvalidArgumentException;

class MakeUserException extends InvalidArgumentException
{
    /**
     * The supplied email is invalid.
     *
     * @param  string  $email
     * @return \App\Exceptions\MakeUserException
     */
    public static function invalidEmail($email)
    {
        return new static("The email address [{$email}] is invalid");
    }

    /**
     * The supplied email already exists.
     *
     * @param  string  $email
     * @return \App\Exceptions\MakeUserException
     */
    public static function emailExists($email)
    {
        return new static("A user with the email address {$email} already exists");
    }
}
