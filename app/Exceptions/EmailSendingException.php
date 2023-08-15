<?php
/**
 * Class EmailSendingException
 *
 * PHP Version >= 8.1
 *
 * @category Exception
 * @package  App\Exceptions
 * @author   Moses Egboh <mosesegboh@yahoo.com>
 * @license  https://github.com/mosesegboh/sendemails.git MIT
 * @link     https://github.com/mosesegboh/sendemails.git
 */
namespace App\Exceptions;

use Exception;
/**
 * Class EmailSendingException
 *
 * PHP Version >= 8.1
 *
 * @category Exception
 * @package  App\Exceptions
 * @author   Moses Egboh <mosesegboh@yahoo.com>
 * @license  https://github.com/mosesegboh/sendemails.git MIT
 * @link     https://github.com/mosesegboh/sendemails.git
 */
class EmailSendingException extends Exception
{
    /**
     * Custom message for the exception.
     *
     * @return string the exception message.
     */
    public function errorMessage()
    {
        $errorMsg = 'Error on line ' . $this->getLine() . ' in ' . $this->getFile()
            . ': <b>' . $this->getMessage() . '</b> is not a valid E-Mail address';

        return $errorMsg;
    }
}
