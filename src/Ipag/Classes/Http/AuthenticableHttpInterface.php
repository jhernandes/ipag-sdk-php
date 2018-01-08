<?php

namespace Ipag\Classes\Http;

interface AuthenticableHttpInterface
{
    public function setUser($user);

    public function setPassword($password);
}
