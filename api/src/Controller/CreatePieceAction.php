<?php

namespace App\Controller;

use App\Entity\Piece;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]

class CreatePieceAction extends AbstractController
{
    public function __invoke(Request $request): Piece
    {
        $piece = $request->attributes->all()['data'];
        $uploadedFile = $request->files->get('file');
        /** @var UploadedFile $uploadedFile */
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }
        dd($uploadedFile);
        $piece->file = $uploadedFile;

        return $piece;
    }
}
