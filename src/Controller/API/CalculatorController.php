<?php

namespace App\Controller\API;

use App\DTO\Calculator\CalculatorDTO;
use App\DTO\Calculator\ResponseDTO;
use App\Service\Calculator\CalculatorService;
use App\Shared\Controller\BaseController;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class CalculatorController extends BaseController
{
    public function __construct(
        SerializerInterface $serializer,
        private readonly CalculatorService $calculatorService,
    ) {
        parent::__construct($serializer);
    }

    #[Route('/calculate', methods: ['POST'])]
    #[OA\Tag(name: 'calculate')]
    #[OA\Response(
        response: 400,
        description: 'Returned when input data not valid',
    )]
    #[OA\Response(
        response: 200,
        description: 'Returned when success calculate',
        content: new Model(type: ResponseDTO::class)
    )]
    #[OA\RequestBody(
        description: 'Result',
        content: new Model(type: CalculatorDTO::class)
    )]
    public function calculate(Request $request): Response
    {
        try {
            $dto = $this->getData($request, CalculatorDTO::class);

            $data = $this->calculatorService->calculate($dto);
        } catch (\Throwable $e) {
            return $this->error($e->getMessage());
        }

        return $this->success($data);
    }
}
