<?php namespace App\Services;

use Mail;
use App\Services\MailerInterface;

/**
 * Class Mailer
 * @package App\Services
 * @author Phillip Madsen
 */
class Mailer implements MailerInterface
{

    public function send($view, $email, $subject, $data = array())
    {

        Mail::send($view, $data, function ($message) use ($email, $subject) {

            $message->from('noreply@fullycms.com');
            $message->to($email)->subject($subject);
        });
    }

    public function queue($view, $email, $subject, $data = array())
    {

        Mail::queue($view, $data, function ($message) use ($email, $subject) {

            $message->from('noreply@fullycms.com');
            $message->to($email)->subject($subject);
        });
    }
}
