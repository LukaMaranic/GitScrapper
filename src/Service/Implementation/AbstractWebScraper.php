<?php

namespace App\Service\Implementation;

abstract class AbstractWebScraper
{
    /**
     * @return mixed
     */
    abstract function scrape();
}