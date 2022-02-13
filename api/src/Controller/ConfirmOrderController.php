<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Repository\PieceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpFoundation\Response;

#[AsController]
class ConfirmOrderController extends AbstractController
{
    public function __invoke(Request $request, OrderRepository $orderRepository, PieceRepository $pieceRepository)
    {
        $required = ['piece_ids', 'address', 'zip_code', 'city'];
        $decoded = json_decode($request->getContent(), true);
        foreach ($required as $key) {
            if (!array_key_exists($key, $decoded) || empty($decoded[$key])) {
                return new Response('Missing required field: '.$key, 400);
            }
        }

        if (! $pieceRepository->areAvailables($decoded['piece_ids']))
            return new Response('Some product are not available', 400);

        if ($this->getUser()->getCredits() < count($decoded['piece_ids'])) {
            return new Response('Not enough credits', 400);
        }

        $pieceRepository->setSoldPieces($decoded['piece_ids']);
        $orderRepository->createOrder(
            $this->getUser(),
            $pieceRepository->findBy(['id' => $decoded['piece_ids']]),
            $decoded['address'],
            $decoded['zip_code'],
            $decoded['city'],
            count($decoded['piece_ids'])
        );



        return new Response('', Response::HTTP_OK);

    }
}
