<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Homepage;
use App\Models\Settings;
use App\Models\Aboutpage;
class Home extends Controller
{
    public function store(Request $request,$id){
        $home= Homepage::find($id);
        if($request->hasFile('homepage_background_video')){

            $file = $request->file('homepage_background_video');
            $filename = time().$file->getClientOriginalName();
            $file->move(public_path('storage/homepage/video'), $filename);
            $home->homepage_background_video=$filename;
        }
        if($request->hasFile('homepage_gift_card_img_one')){

            $file = $request->file('homepage_gift_card_img_one');
            $filename = time().$file->getClientOriginalName();
            $file->move(public_path('storage/homepage/'), $filename);
            $home->homepage_gift_card_img_one=$filename;
        }
        if($request->hasFile('homepage_gift_card_img_two')){

            $file = $request->file('homepage_gift_card_img_two');
            $filename = time().$file->getClientOriginalName();
            $file->move(public_path('storage/homepage/'), $filename);
            $home->homepage_gift_card_img_two=$filename;
        }
        if($request->hasFile('homepage_gift_card_img_three')){

            $file = $request->file('homepage_gift_card_img_three');
            $filename = time().$file->getClientOriginalName();
            $file->move(public_path('storage/homepage/'), $filename);
            $home->homepage_gift_card_img_three=$filename;
        }
        if($request->hasFile('homepage_section_three_image')){

            $file = $request->file('homepage_section_three_image');
            $filename = time().$file->getClientOriginalName();
            $file->move(public_path('storage/homepage/'), $filename);
            $home->homepage_section_three_image=$filename;
        }
        if($request->hasFile('homepage_section_three_bottom_image')){

            $file = $request->file('homepage_section_three_bottom_image');
            $filename = time().$file->getClientOriginalName();
            $file->move(public_path('storage/homepage/'), $filename);
            $home->homepage_section_three_bottom_image=$filename;
        }

        if($request->hasFile('homepage_section_seven_img_one')){

            $file = $request->file('homepage_section_seven_img_one');
            $filename = time().$file->getClientOriginalName();
            $file->move(public_path('storage/homepage/'), $filename);
            $home->homepage_section_seven_img_one=$filename;
        }

        if($request->hasFile('homepage_section_seven_img_two')){

            $file = $request->file('homepage_section_seven_img_two');
            $filename = time().$file->getClientOriginalName();
            $file->move(public_path('storage/homepage/'), $filename);
            $home->homepage_section_seven_img_two=$filename;
        }
        
        $home->homepage_first_heading=$request->homepage_first_heading;
        $home->homepage_second_heading=$request->homepage_second_heading;
        $home->homepage_section_three_heading=$request->homepage_section_three_heading;
        $home->homepage_section_three_text=$request->homepage_section_three_text;
        $home->homepage_section_three_button_text=$request->homepage_section_three_button_text;
        $home->homepage_section_three_button_link=$request->homepage_section_three_button_link;
        $home->homepage_section_four_heading=$request->homepage_section_four_heading;
        $home->homepage_section_five_heading=$request->homepage_section_five_heading;
        $home->homepage_section_six_heading=$request->homepage_section_six_heading;
        $home->homepage_section_seven_heading=$request->homepage_section_seven_heading;
        $home->homepage_section_seven_desc=$request->homepage_section_seven_desc;
        $home->homepage_section_eight_heading=$request->homepage_section_eight_heading;
        $home->homepage_section_nine_heading=$request->homepage_section_nine_heading;
        $home->homepage_section_tenth_heading=$request->homepage_section_tenth_heading;
        $home->homepage_section_last_heading=$request->homepage_section_last_heading;

        $home->update();
        return redirect()->back()->with('success', 'Homepage Updated!');
    }

   

    public function global_setting(Request $request,$id){
        $setting= Settings::find($id);
        $setting->global_setting_header_text=$request->global_setting_header_text;
        $setting->global_setting_header_text_type=$request->global_setting_header_text_type;
        
        if($request->hasFile('global_setting_song')){
            $file = $request->file('global_setting_song');
            $filename = time().$file->getClientOriginalName();
            $file->move(public_path('storage/global'), $filename);
            $setting->global_setting_song=$filename;
        }
        $setting->save();
        return redirect()->back()->with('success', 'Website Updated!');
    }
}
