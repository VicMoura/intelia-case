<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Validator\UserValidator;

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
        try {

            $data = json_decode($request->getContent(), true);

            // Validar os dados do usuário usando a classe de validação
            $errors = UserValidator::validate($data, false);

            // Se houver erros, retornar a resposta com os erros
            if (!empty($errors)) {
                return $this->json([
                    'error' => $errors
                ], 400);
            }

            // Criar a data de nascimento a partir do formato d/m/Y
            $birthDate = \DateTime::createFromFormat('d/m/Y', $data['birth_date']);

            // Criar o usuário
            $user = new User();
            $user->setFullName($data['full_name']);
            $user->setBirthDate($birthDate);
            $user->setCreatedAt(new \DateTimeImmutable());
            $user->setUpdatedAt(new \DateTimeImmutable());


            // Persistir o usuário no banco de dados
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            // Retornar sucesso
            return $this->json([
                'message' => 'Usuário criado com sucesso!',
                'user' => $user->detail()
            ]);

        } catch (\Exception $e) {
            return $this->json([
                'error' => 'Um erro inesperado ocorreu.'
            ], 500);
        }
    }


    public function update(Request $request, int $id): JsonResponse
    {
        try {

            $data = json_decode($request->getContent(), true);

            $user = $this->entityManager->getRepository(User::class)->find($id);

            if (!$user) {
                return $this->json([
                    'message' => 'Usuário não encontrado!',
                ], 404);
            }

            // Validar os dados do usuário usando a classe de validação
            $errors = UserValidator::validate($data, true); 

            // Se houver erros, retornar a resposta com os erros
            if (!empty($errors)) {
                return $this->json([
                    'error' => $errors
                ], 400);
            }

            if (isset($data['full_name'])) {
                $user->setFullName($data['full_name']);
            }

            if (isset($data['birth_date'])) {
                $birthDate = \DateTime::createFromFormat('d/m/Y', $data['birth_date']);
                if ($birthDate !== $user->getBirthDate()) {
                    $user->setBirthDate($birthDate);
                }
            }

            // Atualizar a data de modificação
            $user->setUpdatedAt(new \DateTimeImmutable());

            // Persistir as alterações no banco de dados
            $this->entityManager->flush();

            // Retornar sucesso
            return $this->json([
                'message' => 'Usuário atualizado com sucesso!',
                'user' => $user->detail()
            ]);
            
        } catch (\Exception $e) {
            return $this->json([
                'error' => 'Não foi possível concluir a atualização',
                'details' => $e->getMessage()
            ], 500);
        }
    }


    public function detail($id): JsonResponse
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            return new JsonResponse(['message' => 'Usuário não encontrado.'], 404);
        }

        return $this->json([
            'message' => 'Informações completas do usuário.',
            'user' => $user->detail()
        ]);

        return new JsonResponse($data);
    }
}
