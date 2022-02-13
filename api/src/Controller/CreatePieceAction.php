<?php

namespace App\Controller;

use App\Entity\Piece;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Service\FileUploader;

#[AsController]

class CreatePieceAction extends AbstractController
{
    public function __invoke(Request $request, FileUploader $fileUploader): Piece
    {
        /** @var Piece $piece */
        $piece = $request->attributes->all()['data'];
        $file = $request->files->get('file');
        /** @var UploadedFile $uploadedFile */
        if (! $file) {
            throw new BadRequestHttpException('"file" is required');
        }
        $filename = $fileUploader->upload($file);
        $piece->file = $file;
        $piece->filePath = '/uploads/' . $filename;

        return $piece;
    }
}
