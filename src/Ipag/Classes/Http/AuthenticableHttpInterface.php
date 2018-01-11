<?php

namespace Ipag\Classes\Http;

interface AuthenticableHttpInterface extends OnlyPostHttpClientInterface
{
    public function setUser($user);

    public function setPassword($password);
}
