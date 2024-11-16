<?php

namespace App\Controller;

use App\Entity\Address;
use App\Repository\AddressRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AddressController extends AbstractController
{
    private $entityManager;
    private $addressRepository;
    private $userRepository;

    public function __construct(EntityManagerInterface $entityManager, AddressRepository $addressRepository, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->addressRepository = $addressRepository;
        $this->userRepository = $userRepository;
    }

    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validação de dados
        if (!isset($data['user_id'], $data['street'], $data['number'], $data['zip_code'], $data['city'], $data['state'])) {
            return $this->json(['error' => 'Missing fields'], 400);
        }

        $user = $this->userRepository->find($data['user_id']);
        if (!$user) {
            return $this->json(['error' => 'User not found'], 404);
        }

        $address = new Address();
        $address->setUserId($user)
                ->setStreet($data['street'])
                ->setNumber($data['number'])
                ->setZipCode($data['zip_code'])
                ->setCity($data['city'])
                ->setState($data['state']);

        $this->entityManager->persist($address);
        $this->entityManager->flush();

        return $this->json([
            'message' => 'Address created successfully!',
            'address' => $address->detail()
        ], 201);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $address = $this->addressRepository->find($id);
        if (!$address) {
            return $this->json(['error' => 'Address not found'], 404);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['street'])) $address->setStreet($data['street']);
        if (isset($data['number'])) $address->setNumber($data['number']);
        if (isset($data['zip_code'])) $address->setZipCode($data['zip_code']);
        if (isset($data['city'])) $address->setCity($data['city']);
        if (isset($data['state'])) $address->setState($data['state']);

        $this->entityManager->flush();

        return $this->json([
            'message' => 'Address updated successfully!',
            'address' => $address->detail()
        ]);
    }
}