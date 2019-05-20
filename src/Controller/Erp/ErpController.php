<?php

namespace App\Controller\Erp;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ErpController
 * @package App\Controller
 * @Route("erp")
 */
class ErpController extends AbstractController
{
    /**
     * @Route("/dashboard", name="erp_dashboard")
     */
    public function dashboard()
    {
        return $this->render('erp/dashboard.html.twig');
    }

}
