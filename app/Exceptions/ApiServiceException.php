<?php


namespace App\Exceptions;

use Exception;
use App\Http\Utils\ResponseUtil;

class ApiServiceException extends Exception
{
    protected $code;
    protected $errors;
    protected $success;

    /**
     * ServiceException constructor.
     * @param $code
     * @param $success
     * @param array $errors
     */
    public function __construct($code, $success, Array $errors)
    {
        $this->code = $code;
        $this->errors = $errors;
        $this->success = $success;
    }

    public function getApiResponse()
    {
        return ResponseUtil::makeArrayResponse($this->code, $this->success, $this->errors);
    }

}
