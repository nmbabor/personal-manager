<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Rules\ValidImageType;
use App\Http\Controllers\Controller;
use DOMDocument;

class WebsiteSettingController extends Controller
{
    public function websiteGeneral()
    {
        return view('backend.settings.website-settings.general');
    }

    public function websiteInfoUpdate(Request $request)
    {
        $request->validate([
            'site_name' => 'required',
            'site_url' => 'url'
        ]);

        foreach ($request->except('_token') as $key => $value) {
            writeConfig($key, $value);
        }

        return to_route('backend.admin.settings.website.general', ['active-tab' => 'website-info'])
            ->with('success', 'Updated successfully');
    }

    public function websiteContactsUpdate(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            if($key == 'google_map'){
                // Your iframe HTML code
                $iframeCode = $value;

                // Create a DOMDocument object
                $dom = new DOMDocument();
                
                // Load the HTML into the DOMDocument
                $dom->loadHTML($iframeCode);
                
                // Get all <iframe> elements
                $iframes = $dom->getElementsByTagName('iframe');
                
                // Check if there is at least one <iframe> element
                if ($iframes->length > 0) {
                    // Get the src attribute of the first <iframe> element
                    $src = $iframes->item(0)->getAttribute('src');
                    
                    // Output the src attribute
                    $value = $src;
                } else {
                    $value = "No iframe found.";
                }
            }
            writeConfig($key, $value);
        }

        return to_route('backend.admin.settings.website.general', ['active-tab' => 'contacts'])
            ->with('success', 'Updated successfully');
    }

    public function websiteSocialLinkUpdate(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            writeConfig($key, $value);
        }

        return to_route('backend.admin.settings.website.general', ['active-tab' => 'social-links'])
            ->with('success', 'Updated successfully');
    }

    public function websiteStyleSettingsUpdate(Request $request)
    {
        $request->validate([
            'site_logo' => ['file', new ValidImageType],
            'favicon_icon' => ['file', new ValidImageType],
            'favicon_icon_apple' => ['file', new ValidImageType],
        ]);

        writeConfig('newsletter_subscribe', $request->newsletter_subscribe);

        if ($request->hasFile("site_logo")) {
            secureUnlink(readConfig('site_logo'));
            $site_logo = uploadImage($request->file("site_logo"), "/assets/images/logo");
            writeConfig('site_logo', $site_logo);
        }
        if ($request->hasFile("favicon_icon")) {
            secureUnlink(readConfig('favicon_icon'));
            $favicon_icon = uploadImage($request->file("favicon_icon"), "/assets/images/logo");
            writeConfig('favicon_icon', $favicon_icon);
        }

        return to_route('backend.admin.settings.website.general', ['active-tab' => 'style-settings'])
            ->with('success', 'Updated successfully');
    }

    public function websiteCustomCssUpdate(Request $request)
    {
        writeConfig('custom_css', $request->custom_css);

        return to_route('backend.admin.settings.website.general', ['active-tab' => 'custom-css'])
            ->with('success', 'Updated successfully');
    }

    public function websiteNotificationSettingsUpdate(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            writeConfig($key, $value);
        }

        return to_route('backend.admin.settings.website.general', ['active-tab' => 'notification-settings'])
            ->with('success', 'Updated successfully');
    }

    public function websiteStatusUpdate(Request $request)
    {
        writeConfig('is_live', $request->is_live);

        return to_route('backend.admin.settings.website.general', ['active-tab' => 'website-status'])
            ->with('success', 'Updated successfully');
    }

    // Payment Gateway Settings

    public function pgwSettings(){
        return view('backend.settings.pgw.index');
    }

    public function pgwInfoUpdate(Request $request)
    {

        foreach ($request->except('_token') as $key => $value) {
            writeConfig($key, $value);
        }

        return redirect()->back()->with('success','Successfully updated');
    }
}
