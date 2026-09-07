<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Log;
use Exception;
use Aws\CommandPool;
use Aws\Ses\SesClient;
use GuzzleHttp\Client;
use Aws\ResultInterface;
use Aws\CommandInterface;
use Illuminate\Http\Request;
use Aws\Exception\AwsException;
use Illuminate\Queue\SerializesModels;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Exception\GuzzleException;
class NewsletterEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $emaildata;
    public function __construct($emaildata)
    {
        //
        $this->emaildata = $emaildata;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $maildata = $this->emaildata;
        $client = new SesClient([
            'version' => 'latest',
            'region' => env('AWS_DEFAULT_REGION'),
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' =>env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

       
        $recipients = $maildata['emails'];
       
        //echo "<pre>"; print_r($recipients); die;
       // $recipients = array('yogesh@maxxmann.in','maxxmann.digital@gmail.com'); //temporary
        $source = $maildata['from_name']."<".$maildata['from_email'].">";
        //$source = $maildata['heading'].' <marketing@maxxresponse.com>'; //temporary
        shuffle($recipients);
        // Queue emails as SendEmail commands 
        $i = 100;
        $commands = [];

        

        foreach ($recipients as $recipient) {
            $commands[] = $client->getCommand('SendEmail', [
                // Pass the message id so it can be updated after it is processed (it's ignored by SES)
                'x-message-id' => $i,
                'Source'   => $source,
                'Destination' => [
                    'ToAddresses' => [$recipient],
                ],
                'Message'   => [
                    'Subject' => [
                        'Data'  => $maildata['subject'],
                        'Charset' => 'UTF-8',
                    ],
                    'Body'  => [
                        'Html' => [
                            'Data'  => $maildata['mailbody'],
                            'Charset' => 'UTF-8',
                        ],
                    ],
                ],
            ]);
            $i++;
        }
        //echo "<pre>"; print_r($commands); die;
        try{
            $timeStart = microtime(true);
            $pool = new CommandPool($client, $commands, [
                'concurrency' => 10,
                'before'   => function (CommandInterface $cmd, $iteratorId) {
                    $a = $cmd->toArray();
                    Log::info('About to send ' .$iteratorId .': '. $a['Destination']['ToAddresses'][0]);
                },
                'fulfilled' => function (ResultInterface $result, $iteratorId) use ($commands) {
                    Log::info('Completed ' .$commands[$iteratorId]['x-message-id'].' :'.$commands[$iteratorId]['Destination']['ToAddresses'][0]);
                },
                'rejected'  => function (AwsException $reason, $iteratorId) use ($commands) {
          
                    Log::info('Reason : '.$reason);
                    Log::error('Amazon SES Failed Rejected:' . $commands[$iteratorId]['x-message-id'] . ' :' . $commands[$iteratorId]['Destination']['ToAddresses'][0]);
                },
            ]);
            // Initiate the pool transfers
            $promise = $pool->promise();
            // Force the pool to complete synchronously
            $promise->wait();
            $timeEnd = microtime(true);
        }catch (Exception $e) {
            // echo sprintf('Error: %s' . PHP_EOL, $e->getMessage());
            Log::error('Catch Block: Amazon SES Exception : ' . $e->getMessage());
        }
    }
}
