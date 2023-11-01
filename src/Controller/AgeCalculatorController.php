<?php

namespace App\Controller;

use App\DTO\AgeCalculator\AgeCalculatorDTO;
use App\Service\AgeCalculatorService;
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
final readonly class AgeCalculatorController extends AbstractController
{
    public function __construct(
        private AgeCalculatorService $ageCalculatorService,
        private DTOService $dtoService,
        private SerializerInterface $serializer
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
        $dto = $this->dtoService->getData($request, AgeCalculatorDTO::class);

        try {
            $data = $this->ageCalculatorService->calculateAge($dto);
        } catch (\Throwable $e) {
            return $this->error($e->getMessage());
        }

        return new Response($this->serializer->serialize($data, JsonEncoder::FORMAT), Response::HTTP_OK);
    }
}
