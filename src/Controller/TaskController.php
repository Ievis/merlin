<?php

namespace App\Controller;

use App\Entity\Task;
use App\Exception\FileExsists;
use App\Resource\TaskResource;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;

class TaskController extends AbstractController
{

    public function show(Request $request, ?Task $task)
    {
        if (empty($task)) abort(404);

        return new TaskResource($task);
    }

    public function create(Request $request)
    {
        $uploadedFile = $request->files->get('image');
        $destination = '/var/www/resources/files';

        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $newFilename = $originalFilename . '-' . uniqid() . '.' . $uploadedFile->guessExtension();

        FileExsists::check($originalFilename);
        $destination = $uploadedFile->move(
            $destination,
            $newFilename
        );

        $task = new Task([
            'name' => $request->request->get('name'),
            'image' => $destination->getPathname()
        ]);
        $task->validated($task, $this->validator);

        $client = HttpClient::create();
        $formData = new FormDataPart([
            'name' => $task->getName(),
            'photo' => DataPart::fromPath($destination)
        ]);

        $response = $client->request('POST', 'http://merlinface.com:12345/api/', [
            'headers' => $formData->getPreparedHeaders()->toArray(),
            'body' => $formData->bodyToIterable()
        ])->toArray();

        if ($response['status'] === 'success') $task->setResult($response['result']);

        $task->setRetryId($response['retry_id']);
        $this->em->persist($task);
        $this->em->flush();

        return new TaskResource($task);
    }
}