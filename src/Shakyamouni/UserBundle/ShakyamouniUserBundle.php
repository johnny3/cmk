<?php

namespace Shakyamouni\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ShakyamouniUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
