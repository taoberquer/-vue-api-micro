<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class OrderController extends AbstractController
{
    public function __invoke(Request $request)
    {
        return  $this->getUser()->getOrders();
    }
}
