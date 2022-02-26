<?php

namespace App\Http\Controllers\Relation;

use App\User;
use App\Models\Phone;
use App\Models\Doctor;
use App\Models\Country;
use App\Models\Patient;
use App\Models\Service;
use App\Models\Hospital;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RelationsController extends Controller
{

    // one to one relationship
    public function hasOneRelation() {
    $user = User::with(['phone' => function($q){
        $q ->select('code', 'phone', 'user_id');
    }])->find(1);
    // return $user -> name;
    // return $user -> phone -> code;
    // return $user -> phone;
    return response() -> json($user);
    }

    // one to one relationship reverse
    public function hasOneRelationReverse(){
        $phone = Phone::with(['user' => function($q){
            $q -> select('id', 'name');
        }])->find(1);
        // make some attribute visible
        $phone ->makeVisible(['user_id']);
        // $phone -> makeHidden(['code']);
        // return $phone -> user;
        return $phone;
    }

    // User Has Phone
    public function getUserHasPhone(){
        return User::whereHas('phone') -> get( );
    }

    // User Has Not Phone
    public function getUserNotHasPhone(){
        return User::whereDoesntHave('phone') -> get();
    }

    // Get User With Condition
    public function getUserWhereHasPhoneWithCondition(){
        return User::whereHas('phone', function($q){
            $q -> where('code' , '02');
        }) -> get( );
    }

    // one to many relationship
    public function getHospitalDoctors(){
        // $hospital = Hospital::find(1);
            // Hospital::where('id',1) -> first();
            // Hospital::first();
        // return $hospital;
            //return $hospital -> doctors;
        //$hospital = Hospital::with('doctors')->find(1);
            // return $hospital;
            //return $hospital -> name;
        /* $doctors = $hospital->doctors;
        foreach ($doctors as $doctor){
            echo  $doctor -> name.'<br>';
        } */
        $doctor = Doctor::find(3);
        return $doctor->hospital->name;
    }

    // Table Hospitals
    public function hospitals(){
        $hospitals = Hospital::select('id', 'name', 'address')->get();
        return view('doctors.hospitals', compact('hospitals'));
    }
    // Table Doctors
    public function doctors($hospital_id)
    {

        $hospital = Hospital::find($hospital_id);
        $doctors = $hospital->doctors;
        return view('doctors.doctors', compact('doctors'));
    }

    // get all hospital which must has doctors
    public function hospitalsHasDoctor(){
        return $hospitals = Hospital::whereHas('doctors')->get();
    }

    // get hospitals has male doctors only
    public function hospitalsHasOnlyMaleDoctors(){
        return $hospitals = Hospital::with('doctors')->whereHas('doctors', function ($q) {
            $q->where('gender', 1);
        })->get();
    }

    // get all hospital which not has doctors
    public function hospitals_not_has_doctors(){
        return Hospital::whereDoesntHave('doctors')->get();
    }

    // Delete Hospital and Doctors
    public function deleteHospital($hospital_id){
        $hospital = Hospital::find($hospital_id);
        if (!$hospital)
            return abort('404');
        //delete doctors in this hospital
        $hospital->doctors()->delete();
        $hospital->delete();
        return redirect() -> route('hospital.all');
    }

    // many to many relationship
    //get doctor with services
    public function getDoctorServices(){
        return $doctor = Doctor::with('services')->find(3);
        //  return $doctor -> services;
    }
    //get service with doctors
    public function getServiceDoctors(){
        return $doctors = Service::with(['doctors' => function ($q) {
            $q->select('doctors.id', 'name', 'title');
        }])->find(1);
    }
    //
    public function getDoctorServicesById($doctorId){
        $doctor = Doctor::find($doctorId);
        $services = $doctor->services;  //doctor services

        $doctors = Doctor::select('id', 'name')->get();
        $allServices = Service::select('id', 'name')->get(); // all db serves

        return view('doctors.services', compact('services', 'doctors', 'allServices'));
    }
    // many to many insert to database
    public function saveServicesToDoctors(Request $request){
        $doctor = Doctor::find($request->doctor_id);
        if (!$doctor)
            return abort('404');
        //$doctor ->services()-> attach($request -> servicesIds);
        //$doctor ->services()-> sync($request -> servicesIds);
        $doctor->services()->syncWithoutDetaching($request->servicesIds);
        return 'success';
    }

    // has one through
    public function getPatientDoctor(){
        $patient = Patient::find(2);
        return $patient->doctor;
    }

    // has many through
    public function getCountryDoctor(){
        $country = Country::find(1);
        return $country->doctors;
    }


}
