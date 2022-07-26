<?php

declare(strict_types=1);

namespace App\Api\Controller\Http\Publication\Create;

use App\Util\HttpRequest\AbstractRequest;

final class CreateRequest extends AbstractRequest
{
    public function getTitle(): string
    {
        return $this->validatedData['title'];
    }

    public function getText(): string
    {
        return $this->validatedData['text'];
    }

    public function getImageId(): ?string
    {
        if (empty($this->validatedData['imageId'])) {
            return null;
        }

        return $this->validatedData['imageId'];
    }

    protected function getRules(): array
    {
        return [
            'title' => 'required|max:250',
            'text' => 'required',
            'imageId' => 'nullable',
        ];
    }

    protected function getMessages(): array
    {
        return [
            'title:required' => 'Заголовок публикации обязателен.',
            'title:max' => 'Заголовок публикации должен быть не более 250 символов.',
            'text:required' => 'Текст публикации обязателен.',
        ];
    }
}
