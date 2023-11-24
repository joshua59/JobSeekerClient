<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\MessageBag;


class Candidate
{
    protected $errors;
    const URL = 'http://127.0.0.1:8000/api/candidate';

    public function getErrors()
    {
        return $this->errors;
    }

    public function setErrors(MessageBag $errors)
    {
        $this->errors = $errors;
    }

    public static function fetchFromApi()
    {
        try {
            $response = Http::get(self::URL);

            if ($response->successful()) {
                $data = $response->json()['data'];
                return collect($data)->map(function ($item) {
                    return (object) $item;
                });
            } else {
                abort($response->status());
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return new Collection();
    }
    public static function storeToApi($data)
    {
        try {
            $response = Http::post(self::URL, $data);

            if ($response->successful()) {
                return true;
            } else {
                $errorMessage = $response->json()['message'] ?? 'Unknown error occurred';

                if ($response->status() === 422) {
                    $validationErrors = $response->json()['errors'] ?? [];
                    $errorMessages = [];

                    foreach ($validationErrors as $field => $errors) {
                        $errorMessages[] = ucfirst($field) . ': ' . implode(', ', $errors);
                    }

                    return 'Failed to create candidate via API. Validation error: ' . implode(' | ', $errorMessages);
                } else {
                    return 'Failed to create candidate via API. Error: ' . $errorMessage;
                }
            }
        } catch (\Exception $e) {
            return 'Exception occurred: ' . $e->getMessage();
        }
    }


    public static function getCandidateFromApi($id)
    {
        try {
            $response = Http::get(self::URL."/{$id}");

            if ($response->successful()) {
                return (object) $response->json('data');
            } else {
                Log::error('Failed to fetch candidate via API');
                return null;
            }
        } catch (\Exception $e) {
            Log::error('Exception occurred: ' . $e->getMessage());
            return null;
        }
    }


    public static function updateInApi($id, $data)
    {
        try {
            $response = Http::patch(self::URL."/{$id}", $data);

            if ($response->successful()) {
                return true;
            } else {
                $errorMessage = $response->json()['message'] ?? 'Unknown error occurred';

                if ($response->status() === 422) {
                    $validationErrors = $response->json()['errors'] ?? [];
                    $errorMessages = [];

                    foreach ($validationErrors as $field => $errors) {
                        $errorMessages[] = ucfirst($field) . ': ' . implode(', ', $errors);
                    }

                    return 'Failed to create candidate via API. Validation error: ' . implode(' | ', $errorMessages);
                } else {
                    return 'Failed to create candidate via API. Error: ' . $errorMessage;
                }
            }
        } catch (\Exception $e) {
            return 'Exception occurred: ' . $e->getMessage();
        }
    }

    public static function deleteFromApi($id)
    {
        try {
            $response = Http::delete(self::URL."/{$id}");

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Exception occurred: ' . $e->getMessage());
            return false;
        }
    }
}
