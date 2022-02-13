<?php

namespace App\Controller;

use App\Entity\Donation;
use App\Entity\Order;
use App\Repository\CategoryRepository;
use App\Repository\DonationRepository;
use App\Repository\OrderRepository;
use App\Repository\PieceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpFoundation\Response;

#[AsController]
class CreateDonationController extends AbstractController
{
    public function __invoke(Request $request, EntityManagerInterface $entityManager, DonationRepository $donationRepository, CategoryRepository $categoryRepository)
    {
        $decoded = json_decode($request->getContent(), true);

        if (!$decoded || empty($decoded['category_ids'])) {
            return new Response('Invalid JSON', 400);
        }
        $donation = new Donation();
        foreach ($decoded['category_ids'] as $categoryId) {
            $category = $categoryRepository->find($categoryId);
            $donation->addCategory($category);
        }
        $donation->setUser($this->getUser());
        $entityManager->persist($donation);
        $entityManager->flush();

        return new Response('', Response::HTTP_OK);

    }
}
