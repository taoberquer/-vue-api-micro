<?php

namespace App\Controller;

use App\Repository\DonationRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ConfirmDonationController extends AbstractController
{
    public function __invoke($id, EntityManagerInterface $entityManager, Request $request, DonationRepository $donationRepository)
    {
        $donation = $donationRepository->find($id);
        if (! $donation && $donation->getStatus() == 'pending')
            return new Response('Donation not found', 404);
        $credits = json_decode($request->getContent())->credits ?? null;

        if (! $credits)
            return new Response('No credits provided', 400);

        $user = $donation->getUser();
        $user->setCredits($user->getCredits() + $credits);
        $donation->setStatus('confirmed');
        $entityManager->flush();

        return new Response('Donation confirmed', 200);

    }
}
