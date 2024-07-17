<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use Image;
use Config;
use Auth;
use App\Http\Controllers\Controller;

class GeneralSettingsController extends Controller
{
    protected $generalSettings;

    function __construct(GeneralSetting $generalSettings)
    {
        $this->generalSettings = $generalSettings;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(GeneralSetting $generalSetting)
    {

         if(Auth::user()->role == 'user' ){
            return redirect('/dashboard');
        }

        $generalSetting = $this->generalSettings->first();
        $languages = Config::get('languages');

        if ($generalSetting->exists) {
            return redirect(route('settings.edit', $generalSetting->id));
        }else {
            return view('backend.generalsettings.form', compact('generalSetting', 'languages'));
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $generalSetting = new GeneralSetting;
        $generalSetting->company_name = $request->company_name;
        $generalSetting->copyright = $request->copyright;
        $generalSetting->multilanguage = $request->multilanguage;
        $generalSetting->default_language = $request->default_language;
        $generalSetting->address = $request->address;
        $generalSetting->email = $request->email;
        $generalSetting->phone = $request->phone;
        $generalSetting->map = $request->map;
        $generalSetting->email = $request->email;


        $logo = $request->file('logo');
        $filename = time().'-'.$logo->getClientOriginalName();
        Image::make($logo->getRealPath())->save(public_path('upload/general_settings/'.$filename));

        $generalSetting->logo = $filename;

        $generalSetting->save();

        return redirect(route('settings.edit', $generalSetting->id))->with('status', 'Settings has been created!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
          if(Auth::user()->role == 'user' ){
            return redirect('/dashboard');
        }
        $generalSetting = $this->generalSettings->findOrFail($id);
        $languages = Config::get('languages');
        return view('backend.generalsettings.form', compact('generalSetting', 'languages'));
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
        $generalSetting = $this->generalSettings->findOrFail($id);

        $generalSetting->company_name = $request->company_name;
        $generalSetting->copyright = $request->copyright;
        $generalSetting->multilanguage = $request->multilanguage;
        $generalSetting->default_language = $request->default_language;
        $generalSetting->address = $request->address;
        $generalSetting->email = $request->email;
        $generalSetting->phone = $request->phone;
        $generalSetting->map = $request->map;
        $generalSetting->email = $request->email;


        if ($request->hasFile('logo')) {
            $old_logo = $generalSetting->logo;

            if ($old_logo!=null) {
                unlink(public_path('upload/general_settings/'.$old_logo));
            }

            $logo = $request->file('logo');
            $filename = time().'-'.$logo->getClientOriginalName();
            Image::make($logo->getRealPath())->save(public_path('upload/general_settings/'.$filename));

            $generalSetting->logo = $filename;
        }

        $generalSetting->save();

        return redirect(route('settings.edit', $generalSetting->id))->with('status', 'Setting has been updated!');
    }

}
