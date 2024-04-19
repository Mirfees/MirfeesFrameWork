<?php

namespace MyProject\View;

class View
{
    private $templatesPath;

    private $extraVars = [];

    public function __construct(string $templatesPath)
    {
        $this->templatesPath = $templatesPath;
    }

    public function setVars(string $name, $value): void
    {
        $this->extraVars[$name] = $value;
    }

    public function renderHtml(string $templateName, array $vars = [], int $code = 200)
    {
        http_response_code($code);

        extract($this->extraVars);
        extract($vars);

        ob_start();
        include $this->templatesPath . '/' . $templateName;
        $buffer = ob_get_contents();
        ob_end_clean();

        echo $buffer;
    }

    public function renderJson($json, int $code = 200)
    {
        header_remove('Set-Cookie');
        http_response_code($code);
        $httpHeaders = [
            'Content-Type: application/json; content-type: utf-8',
            'HTTP/1.1 200 OK'
        ];
        foreach ($httpHeaders as $httpHeader) {
            header($httpHeader);
        }

        ob_start();
        $buffer = json_encode($json);
        ob_end_clean();

        echo $buffer;
    }
}