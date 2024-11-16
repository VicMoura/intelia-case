<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

class UserController extends AbstractController
{
    private EntityManagerInterface $entityManager;


    // Injeção de dependência via construtor
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $birthDate = \DateTime::createFromFormat('d/m/Y', $data['birth_date']);

        $user = new User();
        $user->setFullName($data['full_name']);
        $user->setBirthDate($birthDate);
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->json([
            'message' => 'Usuário criado com sucesso!',
            'user' => $user->detail()
        ]);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Buscar o usuário pelo ID
        $user = $this->entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            return $this->json([
                'message' => 'Usuário não encontrado!',
            ], 404);
        }

        // Verificar e atualizar os campos enviados no request
        if (isset($data['full_name']) && $data['full_name'] !== $user->getFullName()) {
            $user->setFullName($data['full_name']);
        }

        if (isset($data['birth_date'])) {
            $birthDate = \DateTime::createFromFormat('d/m/Y', $data['birth_date']);
            if ($birthDate !== $user->getBirthDate()) {
                $user->setBirthDate($birthDate);
            }
        }

        $user->setUpdatedAt(new \DateTimeImmutable()); // Atualiza o campo de data

        // Persistir as alterações no banco de dados
        $this->entityManager->flush();

        return $this->json([
            'message' => 'Usuário atualizado com sucesso!',
            'user' => $user->detail()
        ]);
    }


    public function show($id): JsonResponse
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            return new JsonResponse(['message' => 'User not found'], 404);
        }

        $data = [
            'id' => $user->getId(),
            'full_name' => $user->getFullName(),
            'birth_date' => $user->getBirthDate()?->format('Y-m-d'),
            'created_at' => $user->getCreatedAt()?->format('Y-m-d H:i:s'),
            'updated_at' => $user->getUpdatedAt()?->format('Y-m-d H:i:s'),
            'addresses' => $user->getAddresses()->map(function ($address) {
                return $address->toArray();
            })->toArray(),
            'phones' => $user->getPhones()->map(function ($phone) {
                return $phone->toArray();
            })->toArray()        ];

        return new JsonResponse($data);
    }
}
