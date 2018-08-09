<?php

namespace App\Repositories;

use Illuminate\Contracts\Auth\Guard;
use App\LearningModule;
use App\User;
use App\Document;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class LearningModuleRepository
{
    /**
     * Get the latest learning modules
     *
     * @param int $take
     * @param string $query
     * @return Illuminate\Support\Collection
     */
    public function all($take = 10, $sort = 'desc', $query = '')
    {
        // Setup the query for getting learning modules
        $learningModules = LearningModule::with([
            'author'
        ])->orderBy('updated_at', $sort);

        // If a search query is provided then find learning modules by title
        if ($query) {
            $learningModules->searchTitle($query);
        }

        return $learningModules->paginate($take);
    }

    /**
     * Store a new document on this learning module
     *
     * @param LearningModule $learningModule
     * @param UploadedFile $file
     * @param array $properties
     */
    public function document(LearningModule $learningModule, UploadedFile $file, $properties)
    {
        // Create a new document
        $document = new Document;
        $document->extension = $file->getClientOriginalExtension();
        $document->author_id = \Auth::id();
        $document->title = $file->getClientOriginalName();
        $document->description = array_get($properties, 'title');

        // Create a new obfuscated filename
        $filename = str_random(16) . '.' . $document->extension;

        // Move the file to a more sensible location
        $file->move(public_path('uploads'), $filename);

        // Store the new path on the document
        $document->path = '/uploads/' . $filename;

        // Attach the new document to the learning module
        return $learningModule->documents()->save($document);
    }
}
