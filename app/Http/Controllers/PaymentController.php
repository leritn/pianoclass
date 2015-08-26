<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\models\Teacher;
use App\models\Student;
use App\models\Payment;
use Validator;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $payments = Payment::paymentlist();
       
        return view("payment.index",['payments'=>$payments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $teacher = Teacher::teacherList();
        $student = Student::studentList();
        //print_r($teacher);die();
        return view('payment.addhours',['teacherlist'=>$teacher , 'studentlist'=>$student ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $payment = new Payment;

        $payment->teachers_id = $request->teachers_id;
        $payment->students_id = $request->students_id;
        $payment->hours = $request->hours;
        $payment->save();

        return redirect('payment');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $payments = Payment::paymentById($id);

        $teacherlist =  Teacher::teacherList();
        $studentlist = Student::studentList();
        return view('payment.edit',['teacherlist'=>$teacherlist , 'studentlist'=>$studentlist , 'paymentById'=>$payments]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
         $validator = Validator::make($request->all(), Payment::$rulesPayment);

        if ($validator->fails()) {

            return redirect('payment/'.$id.'/edit')->withErrors($validator);

        } 
        else {
            $payment = Payment::where('students_payments.id',$id)->first();

            $payment->teachers_id = $request->teachers_id;
            $payment->students_id = $request->students_id;
            $payment->hours = $request->hours;

            $payment->save();

            return redirect('payment');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
