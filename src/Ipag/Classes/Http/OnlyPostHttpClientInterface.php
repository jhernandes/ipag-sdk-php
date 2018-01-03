<?php

namespace Ipag\Classes\Http;

interface OnlyPostHttpClientInterface
{
    public function __invoke($url, array $headers = [], array $fields = []);
}
