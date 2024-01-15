<?php

namespace Controller;

use App\Controller\BaseController;
use App\Service\Implementation\IssuesService;
use App\Service\Implementation\TokenService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;

class BaseControllerTest extends KernelTestCase
{
    public function testHomePage(): void
    {
        // Mock the required services
        $gitIssuesServiceMock = $this->createMock(IssuesService::class);
        $gitHubTokenServiceMock = $this->createMock(TokenService::class);

        // Set up the controller with the mocked services
        $controller = new BaseController($gitIssuesServiceMock, $gitHubTokenServiceMock);

        // Create a mock Request object
        $requestMock = $this->createMock(Request::class);

        // Call the method being tested
        $response = $controller->homePage($requestMock);

        // Assert that the response is an instance of Symfony\Component\HttpFoundation\Response
        $this->assertInstanceOf(\Symfony\Component\HttpFoundation\Response::class, $response);

        // Add more specific assertions based on your application logic
    }


}
