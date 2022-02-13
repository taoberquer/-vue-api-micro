<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class DonationController extends AbstractController
{
    public function __invoke(Request $request)
    {
        return  $this->getUser()->getDonations();
    }
}
