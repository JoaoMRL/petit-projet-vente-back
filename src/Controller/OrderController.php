<?php
namespace App\Controller;


use App\Entity\Order;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface; 

#[Route('api/order')]
class OrderController extends  AbstractController
{
  public function __construct(private OrderRepository $repo) {}
   
  #[Route(methods:'GET')]
  public function all(): JsonResponse
  {
    return $this->json($this->repo-> findAll());
  }

  #[Route('/{id}', methods:'GET')]
    public function one (int $id):JsonResponse
    {
        $order=$this->repo->findById($id);
        if ($order == null){
            return $this->json('Resource Not Found', 404);
        }
        return $this->json($order);
    }

    #[Route('/product/{id}', methods:'GET')]
    public function orderIdProduct(int $id):JsonResponse
    {
        $product=$this->repo->FindProductbyOrderresId($id);
        if ($product == null){
            return $this->json('Resource Not Found', 404);
        }
        return $this->json($product);
    }

    #[Route('/option/{id}', methods:'GET')]
    public function orderIdOption(int $id):JsonResponse
    {
        $option=$this->repo->FindOptionByOrderId($id);
        if ($option == null){
            return $this->json('Resource Not Found', 404);
        }
        return $this->json($option);
    }

   #[Route('/{id}', methods:'DELETE')] 
   
    public function delete(int $id): JsonResponse
    {
        $order = $this->repo->findById($id);
        if($order == null) {
            return $this->json('Resource Not Found', 404);
        }
        $this->repo->delete($id);
        return $this->json(null, 204);
    }

    #[Route('/{id}', methods: 'PATCH')]
    public function undate(int $id, Request $request, SerializerInterface $serializer, ValidatorInterface $validator)
   {
        $order = $this->repo->findById($id);
        if ($order == null) {
            return $this->json('Resource Not Found', 404);
        }
        try {
            $serializer->deserialize($request->getContent(), Order::class,'json', [
                'object_tppopulate' => $order
            ]);
        } catch (\Exception $error) {
                return $this->json('Invalid body', 400);
            }
            $errors = $validator->validate($order);
            if ($errors->count() >0) {
                return $this ->json(['errors'=> $errors], 400);
            }
            $this->repo->update($order);
            return $this->json($order);
    }

    #[Route(methods: 'POST')]
    public function add(Request $request, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        try {
            $order = $serializer->deserialize($request->getContent(), Order::class, 'json');   
        } catch(\Exception $error){
            return $this->json('Invalid body', 400);
        }
        $errors = $validator->validate($order);
        if ($errors->count() > 0){
            return $this->json(['errors' => $errors], 400);
        }
        $this->repo->persist($order);
        return $this->json($order, 201);
    }


}

