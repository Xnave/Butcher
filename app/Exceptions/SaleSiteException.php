<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 20/08/2015
 * Time: 13:03
 */

namespace App\Exceptions;


use League\Flysystem\Exception;

class SaleSiteException extends Exception
{
    public $validator;
    /**
     * VlaueNotUniqueException constructor.
     * @param $value
     */
    public function __construct($message)
    {
        parent::__construct("Nave Exception " . $message);
    }




}