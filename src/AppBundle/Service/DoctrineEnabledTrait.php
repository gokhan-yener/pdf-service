<?php

namespace AppBundle\Service;

use Doctrine\ORM\Query;

trait DoctrineEnabledTrait
{
    public function getHydrationMode($hydration = 'object')
    {
        switch ($hydration) {
            case 'object':
                $hydrationMode = Query::HYDRATE_OBJECT;
                break;
            case 'array':
                $hydrationMode = Query::HYDRATE_ARRAY;
                break;
            case 'scalar':
                $hydrationMode = Query::HYDRATE_SCALAR;
                break;
            case 'single_scalar':
                $hydrationMode = Query::HYDRATE_SINGLE_SCALAR;
                break;
            case 'simple_object':
                $hydrationMode = Query::HYDRATE_SIMPLEOBJECT;
                break;
            default: // object
                $hydrationMode = Query::HYDRATE_OBJECT;
        }

        return $hydrationMode;
    }
}
