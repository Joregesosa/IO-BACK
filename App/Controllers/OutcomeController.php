<?php

use Models\Outcome;
use Controllers\Controller;
class OutcomeController extends Controller
{
    public function index()
    {
        try {
            $outcome = new Outcome();
            $outcomes = $outcome->all();
            echo json_encode($outcomes);
        } catch (Exception $e) {
            echo json_encode(['message' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function show($request)
    {
        try {
            $outcome = new Outcome();
            $outcome = $outcome->find($request['id']);
            if ($outcome) {
                echo json_encode($outcome);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Outcome not found']);
            }
        } catch (Exception $e) {
            echo json_encode(['message' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function create($request)
    {
        try {
            $outcome = new Outcome();
            $response = $outcome->create($request['data']);
            echo json_encode(['message' => 'Outcome created successfully', 'data' => $response]);
        } catch (Exception $e) {
            echo json_encode(['message' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function update($request)
    {
        try {
            $outcome = new Outcome();
            $existingOutcome = $outcome->find($request['id']);
            if ($existingOutcome) {
                $outcome->update($request['id'], $request['data']);
                echo json_encode(['message' => 'Outcome updated successfully', 'data' => $outcome->find($request['id'])]);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Outcome not found']);
            }
        } catch (Exception $e) {
            echo json_encode(['message' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function delete($request)
    {
        try {
            $outcome = new Outcome();
            $existingOutcome = $outcome->find($request['id']);
            if ($existingOutcome) {
                $outcome->delete($request['id']);
                echo json_encode(['message' => 'Outcome deleted successfully']);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Outcome not found']);
            }
        } catch (Exception $e) {
            echo json_encode(['message' => 'An error occurred: ' . $e->getMessage()]);
        }
    }
}
