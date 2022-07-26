<?php

declare(strict_types=1);

namespace App\Util\HttpRequest;

use Rakit\Validation\Validation;
use Rakit\Validation\Validator;
use Symfony\Component\HttpFoundation\RequestStack;

abstract class AbstractRequest
{
    /**
     * @var array<mixed>
     */
    protected array $validatedData;

    /**
     * @throws RequestValidationException
     */
    public function __construct(
        private RequestStack $requestStack,
        private Validator $validator,
    ) {
        $currentRequest = $this->requestStack->getCurrentRequest();
        if ($currentRequest->isMethod('GET')) {
            $inputsData = $currentRequest->query->all();
        } else {
            $inputsData = $currentRequest->request->all();
        }

        $rules = $this->getRules();
        $messages = $this->getMessages();

        $validation = $this->validate($inputsData, $rules, $messages);

        $this->validatedData = $validation->getValidatedData();
    }

    /**
     * @return array<mixed>
     */
    abstract protected function getRules(): array;

    /**
     * @return array<mixed>
     */
    abstract protected function getMessages(): array;

    /**
     * @param array<mixed> $inputs
     * @param array<mixed> $rules
     * @param array<mixed> $messages
     * @throws RequestValidationException
     */
    private function validate(array $inputs, array $rules, array $messages): Validation
    {
        $validation = $this->validator->validate($inputs, $rules, $messages);

        $this->checkValidationParameter($validation);

        return $validation;
    }

    /**
     * @throws RequestValidationException
     */
    protected function checkValidationParameter(Validation $validation): void
    {
        if (!$validation->passes()) {
            throw new RequestValidationException($validation->errors()->all());
        }
    }
}
