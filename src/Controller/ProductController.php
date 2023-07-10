<?php
namespace App\Controller;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\Uploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/product')]
class ProductController extends  AbstractController
{
    public function __construct(private ProductRepository $repo){}

    #[Route(methods:'GET')]
    public function all():JsonResponse{
        return $this->json($this->repo->findAll());
    }


    #[Route('/{id}',methods:'DELETE')]
    public function delete(int $id):JsonResponse{
        $shop = $this->repo->findById($id);
        if($shop==null ){
            return $this->json('Resource Not found',404);
        }
        $this->repo->delete($id);
        return $this->json(null,204);
    }
    
    #[Route('/{id}', methods: 'PATCH')]
    public function update(int $id, Request $request, SerializerInterface $serializer, ValidatorInterface $validator)
    {
     $shop = $this->repo->findById($id);
     if ($shop == null){
        return $this->json('Resource Not found', 404);
     }
     try {
        $serializer->deserialize($request->getContent(),Product::class, 'json', ['object_to_populate' => $shop]);
     } catch (\Exception $error) {
        return $this->json('Invalid body', 400);
     }
     $errors = $validator->validate($shop);
     if ($errors->count() > 0) {
        return $this->json(['errors' => $errors], 400);
     }
     $this->repo->update($shop);
     return $this->json($shop);
    }

    
    #[Route(methods: 'POST')]
    public function add(Request $request, SerializerInterface $serializer, ValidatorInterface $validator, Uploader $uploader)
    {
        try {
            $shop = $serializer->deserialize($request->getContent(), Product::class, 'json');   
        } catch(\Exception $error){
            return $this->json('Invalid body', 400);
        }
        $errors = $validator->validate($shop);
        if ($errors->count() > 0){
            return $this->json(['errors' => $errors], 400);
        }
        if ($shop->getPicture()) {
            $filename=$uploader->upload($shop->getPicture());
            $shop->setPicture($filename);
        }
        $this->repo->persist($shop);
        return $this->json($shop, 201);
    }

    #[Route('/{id}', methods: 'GET')]
    public function one(int $id): JsonResponse
    {
        $shop = $this->repo->findById($id);
        if ($shop == null) {
            return $this->json('Resource Not found' , 404);
        }
        return $this->json($shop);
    }
}
