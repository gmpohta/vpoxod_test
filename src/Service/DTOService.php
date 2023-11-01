<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

final readonly class DTOService
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
    public function getData(Request $request, string $dto)
    {
        $body = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        return $this->serializer->deserialize(json_encode($body, JSON_THROW_ON_ERROR), $dto, JsonEncoder::FORMAT);
    }
}
