<?php

namespace Dngu\WebBundle\Authority;

class StatisticsAuthority extends BaseAuthority
{
    public function hasCreateAuthority()
    {
        return true;
    }

    public function hasDeleteAuthority()
    {
        return false;
    }

    public function hasUpdateAuthority()
    {
        return true;
    }

}
