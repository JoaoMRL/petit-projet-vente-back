<?php
namespace App\Controller;
use App\Entity\Option;
use App\Repository\OptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface; 

#[Route('/api/option')]
class OptionController extends  AbstractController
{
    public function __construct(private OptionRepository $repo){}

    #[Route(methods:'GET')]
    public function all():JsonResponse{
        return $this->json($this->repo->findAll());
    }

    #[Route('/{id}',methods:'DELETE')]
    public function delete(int $id):JsonResponse{
        $option = $this->repo->findById($id);
        if($option==null ){
            return $this->json('Resource Not found',404);
        }
        $this->repo->delete($id);
        return $this->json(null,204);
    }

    #[Route('/{id}', methods: 'PATCH')]
    public function update(int $id, Request $request, SerializerInterface $serializer, ValidatorInterface $validator)
    {
     $option = $this->repo->findById($id);
     if ($option == null){
        return $this->json('Resource Not found', 404);
     }
     try {
        $serializer->deserialize($request->getContent(),Option::class, 'json', ['object_to_populate' => $option]);
     } catch (\Exception $error) {
        return $this->json('Invalid body', 400);
     }
     $errors = $validator->validate($option);
     if ($errors->count() > 0) {
        return $this->json(['errors' => $errors], 400);
     }
     $this->repo->update($option);
     return $this->json($option);
    }

    #[Route(methods: 'POST')]
    public function add(Request $request, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        try {
            $option = $serializer->deserialize($request->getContent(), Option::class, 'json');   
        } catch(\Exception $error){
            return $this->json('Invalid body', 400);
        }
        $errors = $validator->validate($option);
        if ($errors->count() > 0){
            return $this->json(['errors' => $errors], 400);
        }
        $this->repo->persist($option);
        return $this->json($option, 201);
    }

    #[Route('/{id}', methods: 'GET')]
    public function one(int $id): JsonResponse
    {
        $option = $this->repo->findById($id);
        if ($option == null) {
            return $this->json('Resource Not found' , 404);
        }
        return $this->json($option);
    }
}
