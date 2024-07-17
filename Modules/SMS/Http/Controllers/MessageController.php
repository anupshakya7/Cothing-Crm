<?php

namespace Modules\SMS\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SMS\Entities\Message;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $messages = Message::latest()->get();
        return view('sms::message.index',compact('messages'));
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
        $message = new Message();
		
		$message->title = $request->title;
		$message->body = $request->body;
		//$education->save();
		
		if($message->save()):
			return back()->with("message", "Data added successfully");
			
		else:
			return back()->with("message", "Sorry!! But the data could not be added.");
		endif;
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
    public function update(Request $request)
    {
        $id = $request->msgid;
		$message = Message::find($id);
		
		$message->title = $request->title;
		$message->body = $request->body;
		
		if($message->save()):
			return back()->with("message", "Data Updated successfully");
			
		else:
			return back()->with("message", "Sorry!! But the data could not be updated.");
		endif;
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $message = Message::find($id);

        if(!is_null($message)){
            $message->delete();
            return back()->with('message','Data Deleted Successfully');
        }else{
            return back()->with('message','Sorry!! Message could not be deleted.');
        }
    }
}
