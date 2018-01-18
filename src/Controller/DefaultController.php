<?php

namespace Controller;

use Framework\BaseController;
use Framework\Request;
use Model\Form\FeedbackForm;
use Model\Entity\Feedback;
use Model\Service\ZipService;
use Model\Service\PriceListService;

class DefaultController extends BaseController
{
    public function indexAction(Request $request)
    {
        return $this->render('index.html.twig');

    }

    public function feedbackAction(Request $request)
    {
            $form = new FeedbackForm(
                    $request->post('email'),
                    $request->post('phone'),
                    $request->post('message')
            );

            if ($request->isPost()) {
                if ($form->isValid()) {
                    $feedback = new Feedback(
                        $form->email,
                        $form->phone,
                        $form->message
                    );

                    $this->getRepository('Feedback')->save($feedback);
                    $this
                        ->getRouter()
                        ->redirect('feedback');
                }
            }
        return $this->render('feedback.html.twig', ['form' => $form]);

    }


    public function priceListAction()
    {

        $price = $this->conteiner->get('priceList');
        $books= $this->conteiner->get('repositoryFactory')->createRepository('book')->findAllBooks();
        $price->excelPriceList($books);

    }


}