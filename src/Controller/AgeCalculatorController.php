<?php

namespace App\Controller;

use App\DTO\AgeCalculator\AgeCalculatorDTO;
use App\Service\AgeCalculatorService;
use App\Service\DTOService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api')]
final class AgeCalculatorController extends AbstractController
{
    public function __construct(
        private AgeCalculatorService $ageCalculatorService,
        private DTOService $dtoService,
        private SerializerInterface $serializer,
        private readonly ValidatorInterface $validator,
    ) {
    }

    #[Route('/age-calculate', methods: ['POST'])]
    #[OA\Tag(name: 'age calculate')]
    #[OA\Response(
        response: Response::HTTP_BAD_REQUEST,
        description: 'Returned when input data not valid',
    )]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Returned when success calculate',
    )]
    #[OA\RequestBody(
        description: 'Result',
        content: new Model(type: AgeCalculatorDTO::class)
    )]
    public function calculate(Request $request): Response
    {
        try {
            $dto = $this->dtoService->getData($request, AgeCalculatorDTO::class);

            $errors = $this->validator->validate($dto);

            if ($errors->count() > 0) {
                return new JsonResponse(['error validation' => $this->getErrorMessages($errors)], 400);
            }

            $data = $this->ageCalculatorService->calculateAge($dto);
        } catch (\Throwable $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }

        return new Response($this->serializer->serialize($data, JsonEncoder::FORMAT), Response::HTTP_OK);
    }

    /**
     * @return array<int<0,max>,string|\Stringable>
     */
    private function getErrorMessages(ConstraintViolationListInterface $errors): array
    {
        $errorMessages = [];

        foreach ($errors as $error) {
            $errorMessages[] = $error->getMessage();
        }

        return $errorMessages;
    }
}
