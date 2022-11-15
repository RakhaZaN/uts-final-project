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
    public function show(Patient $patient)
    {
        return $this->response(200, 'Get Detail Resource', $patient);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
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
    public function destroy(Patient $patient)
    {
        $delete = $patient->delete();

        if ($delete) {
            return $this->response(200, 'Resource is Deleted Successfully');
        }

        return $this->response(400, 'Something wrong');
    }

    /**
     * Display a listing of the resource by name
     *
     * @param string $name
     * @return \Illiminate\Http\Response
     */
    public function search($name)
    {
        $searchedPatient = Patient::where('name', 'like', '%' . $name . '%')->get();

        if ($searchedPatient->isEmpty()) {
            return $this->response(404, 'Resource Not Found');
        }

        return $this->response(200, 'Get Searched Resource', $searchedPatient);
    }

    /**
     * Display a listing of the resource with status positive
     *
     * @return \Illuminate\Http\Response
     */
    public function positive()
    {
        $positivePatient = Patient::where('status', 'positive')->get();

        if ($positivePatient->isEmpty()) {
            return $this->response(200, 'Resource Not Available Yet');
        }

        return $this->response(200, 'Get Positive Resource', $positivePatient, true);
    }

    /**
     * Display a listing of the resource with status recovery
     *
     * @return \Illuminate\Http\Response
     */
    public function recovered()
    {
        $recoveredPatient = Patient::where('status', 'recovery')->get();

        if ($recoveredPatient->isEmpty()) {
            return $this->response(200, 'Resource Not Available Yet');
        }

        return $this->response(200, 'Get recovered Resource', $recoveredPatient, true);
    }

    /**
     * Display a listing of the resource with status dead
     *
     * @return \Illuminate\Http\Response
     */
    public function dead()
    {
        $deadPatient = Patient::where('status', 'dead')->get();

        if ($deadPatient->isEmpty()) {
            return $this->response(200, 'Resource Not Available Yet');
        }

        return $this->response(200, 'Get dead Resource', $deadPatient, true);
    }
}
