<?php
namespace Model\Service;

class MailService
{

    private $transport;

    public function __construct(array $mailer)
    {
        $this->transport = (new \Swift_SmtpTransport($mailer['host'], $mailer['port']))
            ->setUsername($mailer['email'])
            ->setPassword($mailer['password'])
            ->setEncryption($mailer['encryption'])
            ->setStreamOptions(array('ssl' => array('allow_self_signed' => $mailer['allow_self_signe'],
                                                    'verify_peer' => $mailer['verify_peer'])))
        ;

    }

    public function mailer()
    {
        $mailer = new \Swift_Mailer($this->transport);

        $message = (new \Swift_Message('Wonderful Subject'))
            ->setFrom(['s03540@ukr.net' => 'John Doe'])
            ->setTo(['s03540@gmail.com' => 'A name'])
            ->setBody('Here is the message itself')
        ;
        $mailer->send($message);

    }

}