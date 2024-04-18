<?php

namespace App\Shared\Application;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

class ValueResolver implements ValueResolverInterface
{
    private array $acceptedValues = [
        'App\Person\Application\PersonCreateCommand',
        'App\Person\Application\PersonUpdateCommand'
    ];

    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface $validator)
    {
    }

    public function resolve(Request $request, ArgumentMetadata $argument): array
    {
        $argumentType = $argument->getType();
        if (
            !$argumentType || (!in_array($argumentType, $this->acceptedValues)  )
        ) {
            return [];
        }

        try {
            $model = $this->serializer->deserialize(
                $request->getContent(),
                $argumentType,
                JsonEncoder::FORMAT
            );
        } catch (Throwable $throwable) {
            throw new RequestBodyConvertException($throwable);
        }

        $errors = $this->validator->validate($model);

        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }

        return [$model];
    }
}
