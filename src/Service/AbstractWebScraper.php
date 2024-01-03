<?php

namespace App\Service;

abstract class AbstractWebScraper
{
    /**
     * @return mixed
     */
    abstract function scrape();
}