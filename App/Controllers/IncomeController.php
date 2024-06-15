<?php

use Models\Income;
use Controllers\Controller;
class IncomeController extends Controller
{
    public function index()
    {
        try {
            $income = new Income();
            $incomes = $income->all();

            echo json_encode($incomes);
        } catch (Exception $e) {
            echo json_encode(['message' => $e->getMessage()]);
        }
    }

    public function show($request)
    {
        try {
            $income = new Income();
            $income = $income->find($request['id']);
            if ($income) {
                echo json_encode($income);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Income not found']);
            }
        } catch (Exception $e) {
            echo json_encode(['message' => $e->getMessage()]);
        }
    }

    public function create($request)
    {
        try {
            $income = new Income();
            $response = $income->create($request['data']);
            echo json_encode(['message' => 'Income created successfully', 'data' => $response]);
        } catch (Exception $e) {
            echo json_encode(['message' => $e->getMessage()]);
        }
    }

    public function update($request)
    {
        try {
            $income = new Income();
            $existingIncome = $income->find($request['id']);
            if ($existingIncome) {
                $income->update($request['id'], $request['data']);
                echo json_encode(['message' => 'Income updated successfully', 'data' => $income->find($request['id'])]);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Income not found']);
            }
        } catch (Exception $e) {
            echo json_encode(['message' => $e->getMessage()]);
        }
    }

    public function delete($request)
    {
        try {
            $income = new Income();
            $existingIncome = $income->find($request['id']);
            if ($existingIncome) {
                $income->delete($request['id']);
                return "Income deleted successfully";
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Income not found']);
            }
        } catch (Exception $e) {
            echo json_encode(['message' => $e->getMessage()]);
        }
    }
}
