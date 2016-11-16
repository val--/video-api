<?php
namespace Tests\VideoBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VideoControllerTest extends WebTestCase{

	private function get($uri, array $data = null)
    {
        $client = static::createClient();
        $client->request('GET', $uri, array(), array(), array(), array());

        return $client->getResponse();
    }

    public function testGetVideos()
    {
        $response = $this->get('/videos');
        $this->assertTrue($response->isSuccessful());
    }

    public function testGetVideosWithParamsFromTo()
    {
        $response = $this->get('/videos?from=20000101&to20161212');
        $this->assertTrue($response->isSuccessful());
    }

    public function testGetVideosWithParamRealisator()
    {
    	// Existing realisator loaded from fixtures
        $response = $this->get('/videos?realisator=Stanley');
        $this->assertTrue($response->isSuccessful());
    }
}