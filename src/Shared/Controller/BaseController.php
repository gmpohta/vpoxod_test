<?php

namespace App\Shared\Controller;

use App\Shared\DTO\IResponseDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

abstract class BaseController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer
    ) {
    }

    /**
     * @template T
     *
     * @param class-string<T> $dto
     *
     * @return T
     *
     * @throws \JsonException
     */
    final public function getData(Request $request, string $dto)
    {
        $body = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        return $this->serializer->deserialize(json_encode($body, JSON_THROW_ON_ERROR), $dto, JsonEncoder::FORMAT);
    }

    final public function handleValidationErrors(ConstraintViolationListInterface $errors): Response
    {
        $errorMessages = $this->getErrorMessages($errors);

        return $this->error('error validation', 400, $errorMessages);
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

    /**
     * @param array<mixed> $data
     */
    final public function error(string $errorMessage, int $code = 500, array $data = []): Response
    {
        $response = [
            'success' => false,
            'data' => $data,
            'message' => $errorMessage,
        ];

        return new Response($this->serializer->serialize($response, JsonEncoder::FORMAT), $code);
    }

    final public function success(IResponseDTO $data, string $message = null, int $code = 200): Response
    {
        $response = [
            'success' => true,
            'data' => $data,
            'message' => $message,
        ];

        return new Response($this->serializer->serialize($response, JsonEncoder::FORMAT), $code);
    }
}
