<?php

namespace App\Validators;

use Illuminate\Validation\Validator;

class CustomValidator extends Validator
{
    // /**
    //  * alpah
    //  *
    //  * @param string $attribute
    //  * @param string $value
    //  * @return true
    //  */
    // public function validateAlpha($attribute, $value)
    // {
    //     return (preg_match("/^[a-z]+$/i", $value));
    // }

    // /**
    //  * alpah_dash
    //  *
    //  * @param string $attribute
    //  * @param string $value
    //  * @return true
    //  */
    // public function validateAlphaDash($attribute, $value)
    // {
    //     return (preg_match("/^[a-z0-9_-]+$/i", $value));
    // }

    // /**
    //  * alpah_num
    //  *
    //  * @param string $attribute
    //  * @param string $value
    //  * @return true
    //  */
    // public function validateAlphaNum($attribute, $value)
    // {
    //     return (preg_match("/^[a-z0-9]+$/i", $value));
    // }

    /**
     * positive_integer
     *
     * @param int $attribute
     * @param int $value
     * @return true
     */
    public function validatePositiveInteger($attribute, $value)
    {
        return (preg_match("/^([1-9][0-9]*|0)+$/i", $value));
    }

    /**
     * zip_code
     *
     * @param string $attribute
     * @param string $value
     * @return true
     */
    public function validateZipCode($attribute, $value)
    {
        return (preg_match("/^[0-9]{3}-[0-9]{4}$/i", $value));
    }

    /**
     * tel
     *
     * @param string $attribute
     * @param string $value
     * @return true
     */
    public function validateTel($attribute, $value)
    {
        return (preg_match("/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}/i", $value));
    }
}
