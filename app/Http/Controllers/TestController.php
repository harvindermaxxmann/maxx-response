<?php
namespace App\Http\Controllers;
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
use App\Jobs\NewsletterEmailJob;
class TestController extends Controller
{


    public function bulkemail(){ 
        $html  = file_get_contents('https://maxxresponse.com/draft/preview/47');
        $emails = array('yogesh@maxxmann.in');
        $emaildata = array('emails'=> $emails,'mailbody'=>$html,'from_name'=>'Maxxmann','from_email'=>'marketing@maxxresponse.com','subject'=>'Test Marketing Maxx Response','heading'=>'Latest Campaign username');
        NewsletterEmailJob::dispatch($emaildata);
    }

 public function bulkemail_old()
  {
    $client = new SesClient([
      'version' => 'latest',
      'region' => 'us-east-1',
      'credentials' => [
        'key' => 'AKIA5OD5QHYGXBXJ3AWB',
        'secret' => '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',
      ],
    ]);
    for($i=1; $i<=2; $i++){
      $recipients[] ='kunalmahajan710@gmail.com';
      
    }
    //echo "<pre>"; print_r($recipients); die;
     // Shuffle recipients for testing purposes
    shuffle($recipients);
    // Queue emails as SendEmail commands
      $i = 100;
    $commands = [];
    foreach ($recipients as $recipient) {
        $commands[] = $client->getCommand('SendEmail', [
         // Pass the message id so it can be updated after it is processed (it's ignored by SES)
          'x-message-id' => $i,
          'Source'   => 'AWS SES parallel test <marketing@maxxresponse.com>',
         'Destination' => [
            'ToAddresses' => [$recipient],
        ],
        'Message'   => [
           'Subject' => [
             'Data'  => 'SES API test',
              'Charset' => 'UTF-8',
           ],
           'Body'  => [
            'Html' => [
                'Data'  => 'This is a <b>test</b>.',
                'Charset' => 'UTF-8',
              ],
            ],
         ],
      ]);
       $i++;
      }
      try
    {
        $timeStart = microtime(true);
        $pool = new CommandPool($client, $commands, [
         'concurrency' => 10,
        'before'   => function (CommandInterface $cmd, $iteratorId) {
           $a = $cmd->toArray();
          // echo sprintf('About to send %d: %s' . PHP_EOL, $iteratorId, $a['Destination']['ToAddresses'][0]);
            Log::info('About to send ' .$iteratorId .': '. $a['Destination']['ToAddresses'][0]);
        },
        'fulfilled' => function (ResultInterface $result, $iteratorId) use ($commands) {
          // echo sprintf(
          //  'Completed %d: %s' . PHP_EOL,
          //  $commands[$iteratorId]['x-message-id'],
           //  $commands[$iteratorId]['Destination']['ToAddresses'][0]
           // );
          Log::info('Completed ' .$commands[$iteratorId]['x-message-id'].' :'.$commands[$iteratorId]['Destination']['ToAddresses'][0]);
        },
        'rejected'  => function (AwsException $reason, $iteratorId) use ($commands) {
          // echo sprintf(
            //  'Failed %d: %s' . PHP_EOL,
          //  $commands[$iteratorId]['x-message-id'],
            //  $commands[$iteratorId]['Destination']['ToAddresses'][0]
           // );
          
           Log::info('Reason : '.$reason);
            Log::error('Amazon SES Failed Rejected:' . $commands[$iteratorId]['x-message-id'] . ' :' . $commands[$iteratorId]['Destination']['ToAddresses'][0]);
          },
      ]);
       // Initiate the pool transfers
       $promise = $pool->promise();
      // Force the pool to complete synchronously
      $promise->wait();
        $timeEnd = microtime(true);
       // echo sprintf('Operation completed in %s seconds' . PHP_EOL, $timeEnd - $timeStart);
      } catch (Exception $e) {
      // echo sprintf('Error: %s' . PHP_EOL, $e->getMessage());
      Log::error('Catch Block: Amazon SES Exception : ' . $e->getMessage());
      }
  }
}