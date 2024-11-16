<?php

namespace App\Controller;

use App\Entity\Phones;
use App\Repository\PhonesRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PhonesController extends AbstractController
{
    private $entityManager;
    private $phonesRepository;
    private $userRepository;

    public function __construct(EntityManagerInterface $entityManager, PhonesRepository $phonesRepository, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->phonesRepository = $phonesRepository;
        $this->userRepository = $userRepository;
    }

    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validação de dados
        if (!isset($data['user_id']) || empty($data)) {
            return $this->json(['error' => 'Missing user_id or phones data'], 400);
        }

        $user = $this->userRepository->find($data['user_id']);
        if (!$user) {
            return $this->json(['error' => 'User not found'], 404);
        }

        unset($data['user_id']);

        // Iterar sobre os dados de telefone e criar os registros
        foreach ($data as $phoneData) {
            if (!isset($phoneData['phone_type'], $phoneData['phone_number'])) {
                return $this->json(['error' => 'Missing phone_type or phone_number'], 400);
            }

            $phone = new Phones();
            $phone->setUserId($user)
                ->setPhoneType($phoneData['phone_type'])
                ->setPhoneNumber($phoneData['phone_number']);

            $this->entityManager->persist($phone);
        }

        $this->entityManager->flush();

        $phones = $this->phonesRepository->findPhonesByUserId($user->getId());

        // Retornar todos os telefones
        return $this->json([
            'message' => 'Phone created successfully!',
            'phones' => array_map(fn($phone) => $phone->detail(), $phones)
        ], 201);
    }


    public function update(int $id, Request $request): JsonResponse
    {
        $phone = $this->phonesRepository->find($id);
        if (!$phone) {
            return $this->json(['error' => 'Phone not found'], 404);
        }

        $data = json_decode($request->getContent(), true);

        // A atualização de múltiplos telefones deve iterar e verificar cada um
        foreach ($data as $phoneData) {
            if (isset($phoneData['phone_type'])) $phone->setPhoneType($phoneData['phone_type']);
            if (isset($phoneData['phone_number'])) $phone->setPhoneNumber($phoneData['phone_number']);
        }

        $this->entityManager->flush();

        return $this->json([
            'message' => 'Phone updated successfully!',
            'phone' => $phone->detail()
        ]);
    }
}
