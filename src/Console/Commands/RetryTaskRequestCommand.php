<?php

namespace App\Console\Commands;

use App\Entity\Task;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpClient\HttpClient;

class RetryTaskRequestCommand extends Command
{
    protected function configure()
    {
        $this->setName('retry-task-request')
            ->setDescription('Retries task request to api');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = require_once 'config/bootstrap.php';
        $qb = $em->createQueryBuilder();

        $tasks = $qb->select('t')
            ->from(Task::class, 't')
            ->where('t.retry_id IS NOT NULL')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();

        $client = HttpClient::create();
        array_map(function ($item) use ($client, $em) {
            try {
                $response = $client->request('POST', 'http://merlinface.com:12345/api/', [
                    'headers' => [
                        'Content-Type: application/json'
                    ],
                    'body' => [
                        'retry_id' => $item->getRetryId()
                    ]
                ])->toArray();

                if ($response['status'] === 'success') {
                    $item->setResult($response['result']);
                    $item->setRetryId(null);

                    $em->persist($item);
                    $em->flush();
                }
            } catch (\Exception $e) {
                $em->remove($item);
                $em->flush();
            }
        }, $tasks);

        sleep(2);
        return Command::SUCCESS;
    }
}