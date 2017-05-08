<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ApiController extends Controller
{
    protected $statusCode = 200;
    protected $sensors = 3;
    protected $sensorLimit = 288;

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function respondNotFound($message = "Not Found")
    {
        return $this->setStatusCode(404)->respondWithError($message);
    }

    public function respondWrongRange($message = "Requested range not satisfiable")
    {
        return $this->setStatusCode(416)->respondWithError($message);
    }

    public function respondSuccess($message = "OK!")
    {
        return $this->setStatusCode(200)->respondWithSuccess($message);
    }

    public function respond($data, $headers = [])
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }

    public function respondWithError($message)
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'status_code' => $this->getStatusCode()
            ]
        ]);
    }
    
    public function respondWithSuccess($message)
    {
        return $this->respond([
            'success' => [
                'message' => $message,
                'status_code' => $this->getStatusCode()
            ]
        ]);
    }

    public function respondWithPagination(LengthAwarePaginator $item, $data)
    {
        $data = array_merge($data, [
        'paginator' => [
                'total_count' => $item->total(),
                'limit' => $item->count(),
                'current_page' => $item->currentPage(),
                'prev_page_url' => $item->previousPageUrl(),
                'next_page_url' => $item->nextPageUrl(),
                'total_page' => $item->lastPage(),
            ]
        ]);
        return $this->respond($data);
    }
}
