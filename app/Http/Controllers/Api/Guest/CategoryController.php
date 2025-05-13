<?php

namespace App\Http\Controllers\Api\Guest;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Traits\ResultService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    use ResultService;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $category = Category::all(['id', 'name']);

            if ($category) {
                $this->setResult($category)->setStatus(true)->setMessage('Success Get Data')->setCode(JsonResponse::HTTP_OK);
            }else{
                $this->setResult(null)->setStatus(false)->setMessage('Failed Failed Get Data')->setCode(JsonResponse::HTTP_CREATED);
            }
        } catch (\Exception $e) {
            $errors['message'] = $e->getMessage();
            $errors['file'] = $e->getFile();
            $errors['line'] = $e->getLine();
            Log::channel('daily')->error('index in CategoryController', $errors);
            $this->setResult($errors)->setStatus(false)->setMessage('An error occurred on the server.')->setCode(JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->toJson();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
         try {
            $category = Category::create($request->all());

            if ($category) {
                $this->setResult($category)->setStatus(true)->setMessage('Success Save Data')->setCode(JsonResponse::HTTP_OK);
            }else{
                $this->setResult(null)->setStatus(false)->setMessage('Failed Failed Save Data')->setCode(JsonResponse::HTTP_CREATED);
            }
        } catch (\Exception $e) {
            $errors['message'] = $e->getMessage();
            $errors['file'] = $e->getFile();
            $errors['line'] = $e->getLine();
            Log::channel('daily')->error('store in CategoryController', $errors);
            $this->setResult($errors)->setStatus(false)->setMessage('An error occurred on the server.')->setCode(JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->toJson();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $category = Category::find($id);

            if ($category) {
                $this->setResult($category)->setStatus(true)->setMessage('Success Get Data')->setCode(JsonResponse::HTTP_OK);
            }else{
                $this->setResult(null)->setStatus(false)->setMessage('Failed Get Data')->setCode(JsonResponse::HTTP_CREATED);
            }
        } catch (\Exception $e) {
            $errors['message'] = $e->getMessage();
            $errors['file'] = $e->getFile();
            $errors['line'] = $e->getLine();
            Log::channel('daily')->error('show in CategoryController', $errors);
            $this->setResult($errors)->setStatus(false)->setMessage('An error occurred on the server.')->setCode(JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->toJson();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
         try {

            $category = Category::find($id)->update($request->all());

            if ($category) {
                $this->setResult($category)->setStatus(true)->setMessage('Success Update Data')->setCode(JsonResponse::HTTP_OK);
            }else{
                $this->setResult(null)->setStatus(false)->setMessage('Failed Failed Update Data')->setCode(JsonResponse::HTTP_CREATED);
            }
        } catch (\Exception $e) {
            $errors['message'] = $e->getMessage();
            $errors['file'] = $e->getFile();
            $errors['line'] = $e->getLine();
            Log::channel('daily')->error('update in CategoryController', $errors);
            $this->setResult($errors)->setStatus(false)->setMessage('An error occurred on the server.')->setCode(JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->toJson();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         try {
            $category = Category::find($id)->delete();

            if ($category) {
                $this->setResult($category)->setStatus(true)->setMessage('Success Delete Data')->setCode(JsonResponse::HTTP_OK);
            }else{
                $this->setResult(null)->setStatus(false)->setMessage('Failed Delete Data')->setCode(JsonResponse::HTTP_CREATED);
            }
        } catch (\Exception $e) {
            $errors['message'] = $e->getMessage();
            $errors['file'] = $e->getFile();
            $errors['line'] = $e->getLine();
            Log::channel('daily')->error('delete in CategoryController', $errors);
            $this->setResult($errors)->setStatus(false)->setMessage('An error occurred on the server.')->setCode(JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->toJson();
    }
}
