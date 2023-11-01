<?php

namespace App\Controller;

use App\DTO\Calculator\CalculatorDTO;
use App\DTO\Calculator\ResponseDTO;
use App\Service\CalculatorService;
use App\Service\DTOService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api')]
final readonly class CalculatorController extends AbstractController
{
    public function __construct(
        private CalculatorService $calculatorService,
        private DTOService $dtoService,
        private SerializerInterface $serializer
    ) {
    }

    #[Route('/calculate', methods: ['POST'])]
    #[OA\Tag(name: 'calculate')]
    #[OA\Response(
        response: Response::HTTP_BAD_REQUEST,
        description: 'Returned when input data not valid',
    )]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Returned when success calculate',
        content: new Model(type: ResponseDTO::class)
    )]
    #[OA\RequestBody(
        description: 'Result',
        content: new Model(type: CalculatorDTO::class)
    )]
    public function calculate(Request $request): Response
    {
        $dto = $this->dtoService->getData($request, CalculatorDTO::class);

        try {
            $data = $this->calculatorService->calculate($dto);
        } catch (\Throwable $e) {
            return $this->error($e->getMessage());
        }

        return new Response($this->serializer->serialize($data, JsonEncoder::FORMAT), Response::HTTP_OK);
    }
}
