<?php

namespace SerwerSMS\SerwerSMSBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SerwerSMSBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
