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
    public function handle()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://atomic.incfile.com/fakepost', [
            'form_params' => [
                'testValue' => 'Test',
            ],
        ]);
        dd($response);
    }
}
