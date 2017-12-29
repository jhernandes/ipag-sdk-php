<?php

namespace Ipag\Http;

interface OnlyPostHttpClientInterface
{
    public function __invoke($url, array $headers = array(), array $fields = array());
}
