<?php

namespace App\Controller;

use App\Entity\Address;
use App\Repository\AddressRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Validator\AddressValidator;

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

        try {
            $data = json_decode($request->getContent(), true);

            // Validar o endereço para criação
            $validationErrors = AddressValidator::validate($data, false);

            // Se houver erros de validação, retornamos um erro
            if (count($validationErrors) > 0) {
                return $this->json([
                    'error' => $validationErrors
                ], 400);
            }

            // Validação de dados
            if (!isset($data['user_id'])) {
                return $this->json(['error' => 'Precisa do user_id para a criação!'], 400);
            }

            $user = $this->userRepository->find($data['user_id']);
            if (!$user) {
                return $this->json(['error' => 'Usuário não encontrado'], 404);
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
                'message' => 'Endereço criado com sucesso!',
                'address' => $address->detail()
            ], 201);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Erro inesperado ocorreu.'], 500);
        }
    }

    public function update(int $id, Request $request): JsonResponse
    {
        try {
            $address = $this->addressRepository->find($id);
    
            if (!$address) {
                return $this->json(['error' => 'Endereço não foi encontrado.'], 404);
            }
    
            $data = json_decode($request->getContent(), true);
    
            // Validar o endereço para atualização
            $validationErrors = AddressValidator::validate($data, true);
    
            // Se houver erros de validação, retornamos um erro
            if (count($validationErrors) > 0) {
                return $this->json([
                    'error' => $validationErrors
                ], 400);
            }
    
            if (isset($data['number'])) $address->setNumber($data['number']);
            if (isset($data['zip_code'])) $address->setZipCode($data['zip_code']);
            if (isset($data['street'])) $address->setStreet($data['street']);
            if (isset($data['city'])) $address->setCity($data['city']);
            if (isset($data['state'])) $address->setState($data['state']);
    
            $this->entityManager->flush();
    
            return $this->json([
                'message' => 'Endereço atualizado com sucesso!',
                'address' => $address->detail()
            ]);
    
        } catch (\Exception $e) {
            return $this->json([
                'error' => 'Ocorreu um erro ao atualizar o endereço.'
            ], 500);
        }
    }
    
}
