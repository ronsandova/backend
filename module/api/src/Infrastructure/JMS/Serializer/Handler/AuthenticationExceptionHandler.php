<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See license.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Api\Infrastructure\JMS\Serializer\Handler;

use Ergonode\Api\Infrastructure\Normalizer\ExceptionNormalizerInterface;
use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigatorInterface;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\Visitor\SerializationVisitorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 */
class AuthenticationExceptionHandler implements SubscribingHandlerInterface
{
    /**
     * @var ExceptionNormalizerInterface
     */
    private $exceptionNormalizer;

    /**
     * @param ExceptionNormalizerInterface $exceptionNormalizer
     */
    public function __construct(ExceptionNormalizerInterface $exceptionNormalizer)
    {
        $this->exceptionNormalizer = $exceptionNormalizer;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribingMethods(): array
    {
        $methods = [];
        $formats = ['json'];

        foreach ($formats as $format) {
            $methods[] = [
                'direction' => GraphNavigatorInterface::DIRECTION_SERIALIZATION,
                'type' => AuthenticationException::class,
                'format' => $format,
                'method' => 'serialize',
            ];
        }

        return $methods;
    }

    /**
     * @param SerializationVisitorInterface $visitor
     * @param AuthenticationException       $exception
     * @param array                         $type
     * @param Context                       $context
     *
     * @return array
     */
    public function serialize(
        SerializationVisitorInterface $visitor,
        AuthenticationException $exception,
        array $type,
        Context $context
    ): array {
        $data = $this->exceptionNormalizer->normalize(
            $exception,
            (string) Response::HTTP_UNAUTHORIZED,
            'Authentication needed'
        );

        return $visitor->visitArray($data, $type);
    }
}
