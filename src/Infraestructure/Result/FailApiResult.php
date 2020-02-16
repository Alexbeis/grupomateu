<?php

namespace Mateu\Infraestructure\Result;

class FailApiResult implements ApiResultInterface
{
    private $content;
    private $error;

    public function __construct(array $content, $error)
    {
        $this->content = $content;
        $this->error = $error;
    }

    public function setContent()
    {

    }

    public function getContent()
    {
        return $this->content;
    }

    public function __toString():string
    {
        return json_encode(
            array_merge(
                $this->getContent(),
                [
                    'success' => false,
                    'error' => $this->error
                ]
            )
        );
    }
}