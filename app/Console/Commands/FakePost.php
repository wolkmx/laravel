<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FakePost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:fakePost';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to generate a Post to IncFile';

    /**
     * Number of attempts to reach the endpoint
     * @var int
     */
    protected $NUM_OF_ATTEMPTS = 10;

    /**
     * Seconds to sleep
     * @var int
     */
    protected $SECONDS_TO_SLEEP = 5;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the the Post request to IncFile.
     *
     * @return mixed
     */
    public function handle() {
        $client = new \GuzzleHttp\Client();
        $url = 'https://atomic.incfile.com/fakepost';
        $response = $this->doRequest($client, $url, 1);
        if ($response->getStatusCode() === 200) {
            echo 'The request was successful and get: ' . $response->getBody();
        }else{
            echo 'The request was successful but the status code is: ' . $response->getStatusCode();
        }
    }

    private function doRequest($client, $url, $attemps) {
        try {
            return $client->request('POST', $url);
            // We can use a more specific exception from guzzle, but for this example I use the generic one
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage() . ', ';
            if ( $this->NUM_OF_ATTEMPTS == $attemps) {
                echo "Can't reach the endpoint in " . $attemps . " attemps";
                // Here we can generate an email to alert about the problem trying to reach the endpoint or schedule a new attemp
                // of course we need to generate more code to create a more complex logic.
                die();
            }
            echo "Trying again attemp number: ". $attemps++ . "\n";
            // I added a sleep statement to minize the risk to get our IP banned for some kind of firewall that could identify
            // this several attemps like a DDoS atack and to try to avoid problems with the connection.
            sleep($this->SECONDS_TO_SLEEP);

            return $this->doRequest($client, $url, $attemps);
        }
    }
}
