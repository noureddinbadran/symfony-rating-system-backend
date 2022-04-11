<?php

namespace App\Tests\Controller;

use App\Entity\Client;
use App\Entity\Rating;
use App\Entity\RatingDetail;
use App\Repository\ClientRepository;
use App\Tests\Controller\Traits\Helpers;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use  Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use function Symfony\Component\DependencyInjection\Loader\Configurator\env;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;

class RatingTest extends WebTestCase
{
    use Helpers;

    private $authToken;
    private $appURL;
    private $firstName;
    private $lastName;
    private $username;
    private ?EntityManager $entityManager;

    protected function setUp(): void
    {
        $this->appURL = 'http://localhost:8000';
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->firstName = base64_encode(random_bytes(10));
        $this->lastName = base64_encode(random_bytes(10));
        $this->username = $this->firstName . $this->lastName .'@gmail.com';

        $this->authToken = $this->getAuthToken();
        $this->assertNotNull($this->authToken);
    }


    public function testIamTryingToRateProjectWithoutAuthentication(): void
    {
        $client = HttpClient::create();
        $url = $this->appURL . '/api/rating';
        $response = $client->request('POST', $url , [
            'json' => [
                'project_id' => 1,
                'overall_satisfaction' => 5,
                'comment' => 'new comment',
                'details' => [
                    'communication' => 4,
                    'quality_of_work' => 2,
                    'value_for_money' => 3.2,
                ],
            ]
        ]);

        // check the status of the response
        $statusCode = $response->getStatusCode();
        $this->assertTrue($statusCode == Response::HTTP_UNAUTHORIZED);
    }

    public function testIamTryingToRateSpecificProject(): void
    {
        $client = HttpClient::create();
        $url = $this->appURL . '/api/rating';
        $response = $client->request('POST', $url , [
            'headers' => [
              'Authorization' => 'Bearer ' . $this->authToken
            ],
            'json' => [
                'project_id' => 1,
                'overall_satisfaction' => 5,
                'comment' => 'new comment',
                'details' => [
                    'communication' => 4,
                    'quality_of_work' => 2,
                    'value_for_money' => 3.2,
                ],
            ]
        ]);

        // check the status of the response
        $statusCode = $response->getStatusCode();
        $this->assertTrue($statusCode == Response::HTTP_OK);

        // check the key of the response(meta data)
        $jsonResponse = json_decode($response->getContent());
        $this->assertEquals($jsonResponse->metaData->key, 'success');

        // check the database to make sure
        $clientRepo = $this->entityManager->getRepository(Client::class);
        $client = $clientRepo->findOneBy([
            'username' => $this->username
        ]);
        $this->assertNotNull($client);

        // check the rating info
        $ratingRepo = $this->entityManager->getRepository(Rating::class);
        $rating = $ratingRepo->findOneBy([
            'client_id' => $client->getId()
        ]);

        $this->assertNotNull($rating);
        $this->assertEquals($rating->getProjectId(), 1);
        $this->assertEquals($rating->getScore(), 5);
        $this->assertEquals($rating->getComment(), 'new comment');
    }

    public function testIamTryingToRateNonExistedProject(): void
    {
        $client = HttpClient::create();
        $url = $this->appURL . '/api/rating';
        $response = $client->request('POST', $url , [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->authToken
            ],
            'json' => [
                'project_id' => 999,
                'overall_satisfaction' => 5,
                'comment' => 'new comment',
                'details' => [
                    'communication' => 4,
                    'quality_of_work' => 2,
                    'value_for_money' => 3.2,
                ],
            ]
        ]);

        // check the status of the response
        $statusCode = $response->getStatusCode();
        $this->assertTrue($statusCode == Response::HTTP_NOT_FOUND);
    }

    public function testIamTryingToRateProjectTwice(): void
    {
        $client = HttpClient::create();
        $url = $this->appURL . '/api/rating';

        // rating for first time
        $response = $client->request('POST', $url , [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->authToken
            ],
            'json' => [
                'project_id' => 1,
                'overall_satisfaction' => 5,
                'comment' => 'new comment',
                'details' => [
                    'communication' => 4,
                    'quality_of_work' => 2,
                    'value_for_money' => 3.2,
                ],
            ]
        ]);

        // check the status of the response
        $statusCode = $response->getStatusCode();

        $this->assertTrue($statusCode == Response::HTTP_OK);

        // rating for second time
        $response = $client->request('POST', $url , [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->authToken
            ],
            'json' => [
                'project_id' => 1,
                'overall_satisfaction' => 5,
                'comment' => 'new comment',
                'details' => [
                    'communication' => 4,
                    'quality_of_work' => 2,
                    'value_for_money' => 3.2,
                ],
            ]
        ]);

        // check the status of the response
        $statusCode = $response->getStatusCode();

        $this->assertTrue($statusCode == Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testIamTryingToRateProjectWithInvalidValues(): void
    {
        $client = HttpClient::create();
        $url = $this->appURL . '/api/rating';

        // rating for first time
        $response = $client->request('POST', $url , [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->authToken
            ],
            'json' => [
                'project_id' => 1,
                'overall_satisfaction' => 5000000,
                'comment' => 'new comment',
                'details' => [
                    'communication' => 40000,
                    'quality_of_work' => -20,
                    'value_for_money' => 20,
                ],
            ]
        ]);

        // check the status of the response
        $statusCode = $response->getStatusCode();

        $this->assertTrue($statusCode == Response::HTTP_BAD_REQUEST);
    }
}
