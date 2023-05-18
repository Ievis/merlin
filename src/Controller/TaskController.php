<?php

namespace App\Controller;

use App\Entity\Task;
use App\Exception\FileExsists;
use App\Resource\TaskResource;
use App\Service\ClientRequest;
use App\Service\FileUpload;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\File;
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
        $task = new Task([
            'name' => $request->request->get('name'),
            'photo' => $request->files->get('photo')
        ]);
        $task->validated($task, $this->validator);

        $uploadedFile = $request->files->get('photo');
        $fileUploadService = new FileUpload($uploadedFile);
        $destination = $fileUploadService->upload();
        $task->setPhoto($destination);

        $formData = new FormDataPart([
            'name' => $task->getName(),
            'photo' => DataPart::fromPath($task->getPhoto())
        ]);

        $clientService = new ClientRequest('http://merlinface.com:12345/api/');
        $response = $clientService->makeDataPartRequest('POST', $formData);

        if ($response['status'] === 'success') $task->setResult($response['result']);

        $task->setRetryId($response['retry_id']);
        $this->em->persist($task);
        $this->em->flush();

        return new TaskResource($task);
    }
}