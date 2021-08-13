<?php

namespace features\Http\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

trait UtilityTrait
{
    /**
     * Gets a single api response
     *
     * @param string $api
     * @param array $payload
     */
    protected function getApiResponse(string $api, array $payload = [])
    {
        $this->response = json_decode($this->post($api, $payload)->getContent());
    }

    /**
     * Gets all the api responses
     *
     * @param $api
     * @param $param
     */
    protected function getApiResponses(string $api, array $param)
    {
        array_push($this->response, json_decode($this->post($api, $param)->getContent()));
    }

    /**
     * Create a csv file in a given location
     *
     * @param $table
     * @param $fileName
     * @param $columns
     */
    protected function createCsvFromFile($table, string $fileName, $columns)
    {
        $file = fopen($fileName, 'w+');
        fputcsv($file, $columns);
        foreach($table as $data) {
            $row = [];
            foreach($columns as $column)
                array_push($row, $data[$column]);
            fputcsv($file, $row);
        }
        fclose($file);
        $this->assertEquals(true, file_exists($fileName));
    }

    /**
     * Get the pay load for a api request
     *
     * @param $payloads
     * @return array
     */
    protected function getPayload($payloads)
    {
        $param = [];
        foreach ($payloads as $payload)
            $param = self::formatPayload($param, $payload);

        return $param;
    }

    /**
     * Format payload
     *
     * @param $param
     * @param $payload
     * @return array
     */
    protected function formatPayload(array $param, array $payload)
    {
        return array_merge($param, [
            $payload['param'] => $payload['param'] == 'verificationCode' ? (int) $payload['value'] : $payload['value']
        ]);
    }

    /**
     *  Get all the routes registered in an application
     */
    public function getAllRoutes() : array
    {
        return array_map(function (\Illuminate\Routing\Route $route)     {
            return $route->uri;
        }, (array) Route::getRoutes()->getIterator());
    }

    /**
     * Check if an route exists
     *
     * @param array $routes
     * @param string $targetRoute
     * @return bool
     */
    public function checkIfRouteExists(array $routes, string $targetRoute)
    {
        return !empty(collect($routes)->search($targetRoute));
    }

    /**
     * Checks if a file exists im the application
     *
     * @param $file
     * @param $function
     */
    public function checkIfRequestHandlerExists (string $file,string $function)
    {
        $this->assertTrue(File::exists($file.'.php'));
        $file = str_replace('/','\\', $file);
        $this->assertTrue(method_exists($file, $function));
    }
}
