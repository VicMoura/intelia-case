<?php

namespace App\Controller;

use App\Entity\Phones;
use App\Repository\PhonesRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Validator\PhoneValidator;

class PhonesController extends AbstractController
{
    private $entityManager;
    private $phonesRepository;
    private $userRepository;
    private $phoneValidator;


    public function __construct(
        EntityManagerInterface $entityManager,
        PhonesRepository $phonesRepository,
        UserRepository $userRepository,
    ) {
        $this->entityManager = $entityManager;
        $this->phonesRepository = $phonesRepository;
        $this->userRepository = $userRepository;
    }

    public function create(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);

            // Recuperar o usuário
            $user = $this->userRepository->find($data['user_id']);
            if (!$user) {
                return $this->json(['error' => 'Usuário não encontrado.'], 404);
            }

            // Validar cada telefone individualmente
            foreach ($data['phones'] as $phoneData) {

                // Validação de dados de telefone
                $validationError = PhoneValidator::validate($phoneData);
                if ($validationError) {
                    return $this->json(['error' => $validationError], 400);
                }

                // Persistir novo telefone
                $phone = new Phones();
                $phone->setUserId($user)
                    ->setPhoneType($phoneData['phone_type'])
                    ->setPhoneNumber($phoneData['phone_number']);
                $this->entityManager->persist($phone);
            }

            // Salvar no banco de dados
            $this->entityManager->flush();

            // Recuperar telefones para o usuário
            $phones = $this->phonesRepository->findPhonesByUserId($user->getId());

            return $this->json([
                'message' => 'Telefones cadastrados com sucesso!',
                'phones' => array_map(fn($phone) => $phone->detail(), $phones)
            ], 201);
        } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
            return $this->json(['error' => 'Não é possível inserir dois números iguais com o mesmo tipo.'], 400);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Erro inesperado ocorreu.'], 500);
        }
    }



    public function update(int $id, Request $request): JsonResponse
    {
        try {

            $phone = $this->phonesRepository->find($id);

            if (!$phone) {
                return $this->json(['error' => 'Telefone não encontrado.'], 404);
            }

            $data = json_decode($request->getContent(), true);

            // Validar os dados de telefone (é um update, então passa true)
            $validationError = $this->phoneValidator->validate($data, true);

            if ($validationError) {
                return $this->json(['error' => $validationError], 400);
            }

            if (isset($data['phone_type'])) {
                $phone->setPhoneType($data['phone_type']);
            }

            if (isset($data['phone_number'])) {
                $phone->setPhoneNumber($data['phone_number']);
            }

            $this->entityManager->flush();

            return $this->json([
                'message' => 'Telefone atualizado com sucesso!',
                'phone' => $phone->detail(),
            ]);
            
        } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
            return $this->json(['error' => 'Não é possível inserir dois números iguais com o mesmo tipo.'], 400);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Erro inesperado ocorreu.'], 500);
        }
    }
}
