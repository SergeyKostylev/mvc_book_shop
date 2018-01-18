<?php

namespace Controller\Admin;

use Framework\BaseController;
use Framework\Request;
use Model\Service\ZipService;
use Model\Service\MailService;

class DefaultController extends BaseController
{
    public function indexAction(Request $request)
    {
        return $this->render('index.html.twig');
    }

    public function getDumpDBAction()
    {
        $command = `mysqldump -uroot mvc > ../TEMP/dump.sql`;
        $zip = $this->conteiner->get('ziper');
        $zip->createZip('dump_sql_db', ["dump.sql" => "../TEMP/dump.sql"]);
        unlink("../TEMP/dump.sql");

    }

    public function mailerAction()
    {
        $this->conteiner->get('mailer')->mailer();
        $redicet = $_SERVER['HTTP_REFERER'];
        @header ("Location: {$redicet}");

    }

}