<?php

namespace Mateu\Infraestructure\Result;

class SuccessApiResult implements ApiResultInterface
{
    private $content;

    public function __construct(array $content)
    {
        $this->content = $content;
    }

    public function setContent()
    {
        // TODO: Implement setContent() method.
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
                    'success' => true,
                ]
            )
        );
    }
}