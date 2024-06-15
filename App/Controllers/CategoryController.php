<?php

use Models\Category;
use Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $category = new Category();
            $categories = $category->all();

            echo json_encode($categories);
        } catch (Exception $e) {
            echo json_encode(['message' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function show($request)
    {
        try {
            $category = new Category();
            $category = $category->find($request['id']);
            if ($category) {
                echo json_encode($category);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Category not found']);
            }
        } catch (Exception $e) {
            echo json_encode(['message' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function create($request)
    {

        try {
            $category = new Category();
            $response = $category->create($request['data']);
            echo json_encode(['message' => 'Category created successfully', 'data' => $response]);
        } catch (Exception $e) {
            echo json_encode(['message' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function update($request)
    {
        try {
            $category = new Category();
            $existingCategory = $category->find($request['id']);
            if ($existingCategory) {
                $category->update($request['id'], $request['data']);
                echo json_encode(['message' => 'Category updated successfully', 'data' => $category->find($request['id'])]);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Category not found']);
            }
        } catch (Exception $e) {
            echo json_encode(['message' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function delete($request)
    {
        try {
            $category = new Category();
            $existingCategory = $category->find($request['id']);
            if ($existingCategory) {
                $category->delete($request['id']);
                echo json_encode(['message' => 'Category deleted successfully']);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Category not found']);
            }
        } catch (Exception $e) {
            echo json_encode(['message' => 'An error occurred: ' . $e->getMessage()]);
        }
    }
}
