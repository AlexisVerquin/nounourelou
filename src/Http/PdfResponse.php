<?php

declare(strict_types=1);

namespace App\Http;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

final class PdfResponse extends Response
{
    private function __construct(string $content)
    {
        parent::__construct($content, Response::HTTP_OK);

        $this->headers->add(['Content-Type' => 'application/pdf']);
        $this->headers->add(['Content-Length' => \strlen($content)]);
        $this->headers->add(['Cache-Control' => 'private, max-age=0, must-revalidate']);
    }

    public static function download(string $content, string $fileName): self
    {
        $response = new self($content);
        $response->headers->add([
            'Content-Disposition' => $response->headers->makeDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT,
                self::sanitizeFileName($fileName)
            ),
        ]);

        return $response;
    }

    public static function display(string $content, string $fileName): self
    {
        $response = new self($content);
        $response->headers->add([
            'Content-Disposition' => $response->headers->makeDisposition(
                ResponseHeaderBag::DISPOSITION_INLINE,
                self::sanitizeFileName($fileName)
            ),
        ]);

        return $response;
    }

    private static function sanitizeFileName(string $fileName): string
    {
        return str_replace(['/', '\\'], '_', $fileName);
    }
}
