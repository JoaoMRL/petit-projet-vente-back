<?php

namespace App\Controller;
use App\Repository\ShopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;



#[Route('/api/shop')]
class ShopController extends AbstractController{

    public function __construct(private ShopRepository $repo){}

    #[Route(methods:'GET')]
    public function all():JsonResponse{
        return $this->json($this->repo->findAll());
    }

    

}