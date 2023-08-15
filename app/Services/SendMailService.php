<?php
/**
 * Class SendMailService
 *
 * PHP Version >= 8.1
 *
 * @category Service
 * @package  App\Services
 * @author   Moses Egboh <mosesegboh@yahoo.com>
 * @license  https://github.com/mosesegboh/sendemails.git MIT
 * @link     https://github.com/mosesegboh/sendemails.git
 */
namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Exceptions\EmailSendingException;
use App\Models\Customer;
/**
 * Class SendMailService
 *
 * PHP Version >= 8.1
 *
 * @category Service
 * @package  App\Services
 * @author   Moses Egboh <mosesegboh@yahoo.com>
 * @license  https://github.com/mosesegboh/sendemails.git MIT
 * @link     https://github.com/mosesegboh/sendemails.git
 */
class SendMailService
{
    /*
    *@throws EmailSendingException
     */
    function sendEmail(string $subject, string $body, string $email): float {
        try {
            Mail::send([], [], function($message) use ($subject, $body, $email) {
                $message->to($email)
                ->subject($subject)
                ->setBody($body, 'text/html');
            });

            return 1.0;
        } catch (EmailSendingException $e) {
            throw new EmailSendingException("Failed to send email: " . $e->errorMessage());
        }
    }

    /**
     * Replace placeholders in the template.
     *
     * @param  string $body
     * @param  Customer $customer
     * @return string
     */
    public static function replacePlaceholders(string $body, Customer $customer): string
    {
        return preg_replace(
            ['/{first_name}/', '/{last_name}/', '/{email}/'],
            [$customer->first_name, $customer->last_name, $customer->email],
            $body
        );
    }

    /**
     * Return and instance of the class for cleaner code.
     *
     */
    public static function instance()
    {
        return new SendMailService();
    }
}
