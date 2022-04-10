<?php

namespace App\Tests\Controller;

use DateTime;
use  Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpClient\HttpClient;

class RatingTest extends WebTestCase
{
    public function testRequest(): void
    {
        $client = HttpClient::create();
        $response = $client->request('POST', 'http://localhost:8000/api/rating', [
            'json' => [
                'project_id' => 1,
                'overall_satisfaction' => 1.5,
                'comment' => 'new comment',
                'details' => [
                    'communication' => 4,
                    'quality_of_work' => 2,
                    'value_for_money' => 3.2,
                ]
            ]
        ]);

        $statusCode = $response->getContent();

        var_dump($statusCode);
        die();
        $this->assertTrue($statusCode == 200);
    }
}
