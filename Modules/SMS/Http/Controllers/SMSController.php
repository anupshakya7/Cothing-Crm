<?php

namespace Modules\SMS\Http\Controllers;

use App\Models\Customer;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SMS\Entities\Message;

class SMSController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $customers = Customer::where('customer_contact_number','!=',null)->orderBy('customer_name','ASC')->get();
        $balance = Message::getBalance();

        return view('sms::sms.index',compact('customers','balance'));
    }

    public function smsSend(Request $request){
         $receiver = explode(', ',$request->des_number);
         if(count($receiver)<3000){
             $apiurl = "https://smssharda.com/backend/sendsms/api?".http_build_query(array(
                 "auth_key"=>"A2VT2DIy27kjRPSrFS_sXBxHz72xCUhj",
                 "from"=>$request->sender_number,
                         "to" => $request->des_number,
                         "message" => $request->message,
                     ));
                 $response = file_get_contents($apiurl);
                 $res=explode('|',$response);

                 if($res[0]==1601):
                     return back()->with("message", "SMS sent successfully...");
                 else:
                     return back()->with("error", "SMS ".$res[1].". Please contact Web Developer.");
                 endif;
         }else{
             return back()->with("error", "Due To Over Trafficing at the network, please send sms to less than 3000 sms at a time");
         }
     }

     public function dateFilter(Request $request){
         $fromDate = $request->from;
         $toDate = $request->to;
         //Filter Customers
         if(!empty($fromDate) && !empty($toDate)){
             $customers = Customer::whereBetween('created_at',[$fromDate,$toDate])->get();
         }else{
             $customers = Customer::where('customer_contact_number','!=',null)->get();
         }

         if($customers){
             return response()->json([
                 'status'=>200,
                 'count'=>count($customers),
                 'customers'=>$customers
             ]);
         }else{
             return response()->json([
                 'status'=>404,
                 'customers'=>"Customer Not Found"
             ]);
         }
     }

     public function CustomerFilter(Request $request){
        $filter_letter = $request->filter_letter;
        $customer_name = $request->customer_name;
        $phone_number = $request->phone_number;

        $query =  Customer::orderBy('customer_name', 'asc');

        if ($filter_letter) {
            $query->where('customer_name', 'like', $filter_letter . '%');
        }

        if ($customer_name) {
            $query->where('customer_name', 'like', '%' . $customer_name . '%');
        }

        if ($phone_number) {
            $query->where('customer_contact_number', $phone_number);
        }

        $customers =  $query->get();

        if($customers){
            return response()->json([
                'status'=>200,
                'count'=>count($customers),
                'customers'=>$customers
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'customers'=>"Customer Not Found"
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('sms::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('sms::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('sms::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
