<?php

namespace Application\Core;

class Response
{
    private $body = [];

    private $message;

    public function __construct(array $body = [], string $message = "")
    {
        $this
            ->setBody($body)
            ->setMessage($message);
    }

    public function setBody(array $body = [])
    {
        $this->body = $body;

        return $this;
    }

    public function getBody(): array
    {
        return $this->body;
    }

    public function setMessage(string $message = "")
    {
        $this->message = $message;

        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getCode(): int
    {
        return http_response_code();
    }

    public function __toString()
    {
        $response = [
            'status'  => $this->getCode(),
            'message' => $this->getMessage(),
            'body'    => $this->getBody(),
        ];

        return json_encode($response);
    }
}
