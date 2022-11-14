<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patients = Patient::all();

        if ($patients->isEmpty()) {
            return $this->response(200, 'Data is Empty');
        }

        return $this->response(200, 'Get All Resource', $patients);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'phone' => 'required|string|max:15|min:11',
            'address' => 'required|string',
            'status' => 'required',
            'in_date_at' => 'required|date',
            'out_date_at' => 'required|date|after_or_equal:in_date_at'
        ]);

        if ($validated->fails()) {
            return $this->response(400, $validated->getMessageBag()->first());
        }

        $create = Patient::create($request->all());

        if ($create) {
            return $this->response(201, 'Resource is Added Successfully', $create);
        }

        return $this->response(400, 'Something wrong');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return $this->response(404, 'Resource not found');
        }

        return $this->response(200, 'Get Detail Resource', $patient);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return $this->response(404, 'Resource not found');
        }

        $validated = Validator::make($request->all(), [
            'name' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:15|min:11',
            'address' => 'nullable|string',
            'status' => 'nullable',
            'in_date_at' => 'nullable|date',
            'out_date_at' => 'nullable|date|after_or_equal:in_date_at'
        ]);

        if ($validated->fails()) {
            return $this->response(400, $validated->getMessageBag()->first());
        }

        $update = $patient->update($request->all());

        if ($update) {
            return $this->response(200, 'Resource is Updated Succesfully', $patient);
        }

        return $this->response(400, 'Something wrong');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return $this->response(404, 'Resource not found');
        }

        $delete = $patient->delete();

        if ($delete) {
            return $this->response(200, 'Resource is Deleted Successfully');
        }

        return $this->response(400, 'Something wrong');
    }
}
