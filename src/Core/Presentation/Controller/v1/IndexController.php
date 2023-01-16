<?php

namespace App\Core\Presentation\Controller\v1;

use App\Core\Presentation\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route(
        '/',
        name: 'index'
    )]
    public function __invoke(): Response
    {
        return new Response('Hello world');
    }
}
