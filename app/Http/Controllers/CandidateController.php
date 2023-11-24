<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidateRequest;
use App\Models\Candidate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class CandidateController extends Controller
{
    public function index()
    {
        $collection = Candidate::fetchFromApi();
        return view('pages.web.index', compact('collection'));
    }

    public function create()
    {
        return view('pages.web.new');
    }

    public function store(CandidateRequest $request)
    {
        $data = $request->all();
        $data['last_salary'] = str_replace(',', '', $data['last_salary']);
        $result = Candidate::storeToApi($data);

        if ($result === true) {
            return redirect()->route('candidates.index')->with('success', 'Candidate created successfully!');
        } else {
            $errors = [];
            if (strpos($result, 'Validation error') !== false) {
                $errorMessages = explode('Validation error:', $result);
                $fieldsErrors = explode('|', trim($errorMessages[1]));

                foreach ($fieldsErrors as $fieldError) {
                    list($field, $message) = explode(':', trim($fieldError));
                    $errors[$field] = $message;
                }
            } else {
                return abort(500);
            }

            return redirect()->back()->withInput()->withErrors($errors);
        }
    }

    public function show($id)
    {
        $candidate = Candidate::getCandidateFromApi($id);

        return view('pages.web.show', compact('candidate'));
    }

    public function edit($id)
    {
        $candidate = Candidate::getCandidateFromApi($id);
        return view('pages.web.edit', compact('candidate'));
    }

    public function update(CandidateRequest $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'phone_number' => 'nullable|numeric',
            'full_name' => 'required|string|max:100',
            'dob' => 'required|date',
            'pob' => 'required',
            'gender' => 'required|in:f,m',
            'year_exp' => 'required|numeric',
            'last_salary' => 'nullable',
        ]);
         if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
        $data = $request->all();
        $data['last_salary'] = str_replace(',', '', $data['last_salary']);
        $result = Candidate::updateInApi($id, $data);

        if ($result === true) {
            return redirect()->route('candidates.index')->with('success', 'Candidate created successfully!');
        } else {
            $errors = [];
            if (strpos($result, 'Validation error') !== false) {
                $errorMessages = explode('Validation error:', $result);
                $fieldsErrors = explode('|', trim($errorMessages[1]));

                foreach ($fieldsErrors as $fieldError) {
                    list($field, $message) = explode(':', trim($fieldError));
                    $errors[$field] = $message;
                }
            } else {
                return abort(500);
            }

            return redirect()->back()->withInput()->withErrors($errors);
        }
    }

    public function destroy($id)
    {
        $deleted = Candidate::deleteFromApi($id);
        if ($deleted) {
            return redirect()->route('candidates.index')->with('success', 'Candidate deleted successfully!');
        } else {
            return redirect()->route('candidates.index')->with('error', 'Failed to delete candidate!');
        }
    }
}
