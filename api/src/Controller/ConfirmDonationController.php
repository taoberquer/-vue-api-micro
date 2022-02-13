<?php

namespace App\Controller;

use App\Repository\DonationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ConfirmDonationController extends AbstractController
{
    protected  $client;
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

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

        $this->client->request(
            'POST',
            $_ENV['MAIL_SERVICE'] . '/donation/confirm',
            ['body' => ['email' => 'tao.berquer@gmail.com']]
        );

        return new Response('Donation confirmed', 200);

    }
}
