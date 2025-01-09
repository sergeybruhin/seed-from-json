<?php

namespace SergeyBruhin\SeedFromJson\Traits;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use ReflectionClass;

trait SeedFromJson
{
    /**
     * @param string $relativePath
     * @param string|null $fileName
     * @param string|null $baseDirectory
     * @return array
     */
    private function readFromJson(string $relativePath, ?string $fileName = 'data.json', ?string $baseDirectory = null): array
    {
        $baseDirectory = $baseDirectory ?? database_path('data');

        $filePath = $fileName ? ($baseDirectory . '/' . $relativePath . '/' . $fileName) : $baseDirectory . '/' . $relativePath;

        $entries = [];


        try {
            $json = File::get($filePath);
        } catch (Exception $exception) {
            $this->command->error($exception->getMessage());
        }

        if (isset($json)) {
            $entries = json_decode($json, true);
        }
        return $entries;
    }

    private function collectFromJson(string $relativePath): Collection
    {
        return collect($this->readFromJson($relativePath));
    }

    private function logModel(Model $model, string $entryName = null): void
    {
        $modelName = (new ReflectionClass($model))->getShortName();

        if (!$entryName) {
            $entryName = $model->{'name'} ?? $model->{'title'} ?? null;
        }
        $this->command->info("— " . ($model->wasRecentlyCreated ? 'Created' : 'Updated') . ' ' . $modelName . ': ' . $entryName);
    }

    /**
     * @param Model $model
     * @return string
     */
    private
    function modelFolderName(Model $model): string
    {
        $modelName = (new ReflectionClass($model))->getShortName();
        return Str::plural(Str::kebab($modelName));
    }

    /**
     * @param Model $model
     * @param string $mediaCollectionName
     * @param string $filePath
     * @param string|null $subDirectory
     * @noinspection PhpUndefinedMethodInspection
     */
    private
    function storeMedia(Model $model, string $mediaCollectionName, string $filePath, string $subDirectory = null): void
    {
        if (!$subDirectory) {
            $subDirectory = $this->modelFolderName($model);
        }

        try {
            $fullPath = $subDirectory . '/' . $filePath;
            $name = md5(Str::uuid());
            $ext = File::extension(database_path('data/' . $fullPath));

            $model->addMedia(database_path('data/' . $fullPath))
                ->usingName($name)
                ->usingFileName("$name.$ext")
                ->preservingOriginal()
                ->toMediaCollection($mediaCollectionName);
        } catch (Exception $exception) {
            $this->command->error($exception->getMessage());
        }
    }

    /**
     * @param Model $model
     * @param string $databaseFieldName
     * @param string $filePath
     * @param string|null $subDirectory
     */
    private
    function readFileToField(Model $model, string $databaseFieldName, string $filePath, string $subDirectory = null): void
    {
        if (!$subDirectory) {
            $subDirectory = $this->modelFolderName($model);
        }

        try {
            $content = File::get(database_path('data/' . $subDirectory . '/' . $filePath));
            $model->{$databaseFieldName} = $content;
        } catch
        (Exception $exception) {
            $this->command->error($exception->getMessage());
        }
    }
}
