<?php

namespace App\Controller\API;

use App\DTO\AgeCalculator\AgeCalculatorDTO;
use App\DTO\AgeCalculator\ResponseDTO;
use App\Service\AgeCalculator\AgeCalculatorService;
use App\Shared\Controller\BaseController;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class AgeCalculatorController extends BaseController
{
    public function __construct(
        SerializerInterface $serializer,
        private readonly AgeCalculatorService $ageCalculatorService,
        private readonly ValidatorInterface $validator,
    ) {
        parent::__construct($serializer);
    }

    #[Route('/age-calculate', methods: ['POST'])]
    #[OA\Tag(name: 'age calculate')]
    #[OA\Response(
        response: 400,
        description: 'Returned when input data not valid',
    )]
    #[OA\Response(
        response: 200,
        description: 'Returned when success calculate age',
        content: new Model(type: ResponseDTO::class)
    )]
    #[OA\RequestBody(
        description: 'Result',
        content: new Model(type: AgeCalculatorDTO::class)
    )]
    public function ageCalculate(Request $request): Response
    {
        try {
            $dto = $this->getData($request, AgeCalculatorDTO::class);

            $errors = $this->validator->validate($dto);

            if ($errors->count() > 0) {
                return $this->handleValidationErrors($errors);
            }

            $data = $this->ageCalculatorService->calculateAge($dto);
        } catch (\Throwable $e) {
            return $this->error($e->getMessage());
        }

        return $this->success($data);
    }
}
