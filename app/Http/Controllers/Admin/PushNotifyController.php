<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Configure;
use App\Models\FirebaseNotify;
use App\Models\Language;
use App\Models\NotifyTemplate;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;

class PushNotifyController extends Controller
{
    public function show()
    {
        $notifyTemplates = NotifyTemplate::groupBy('template_key')->distinct()->orderBy('template_key')->get();
        return view('admin.pushNotify.show', compact('notifyTemplates'));
    }


    public function edit(NotifyTemplate $notifyTemplate, $id)
    {
        $notifyTemplate = NotifyTemplate::findOrFail($id);
        $languages = Language::orderBy('short_name')->get();
        if ($notifyTemplate->notify_for == 0) {
            foreach ($languages as $lang) {
                $checkTemplate = NotifyTemplate::where('template_key', $notifyTemplate->template_key)->where('language_id', $lang->id)->count();

                if ($lang->short_name == 'en' && ($notifyTemplate->language_id == null)) {
                    $notifyTemplate->language_id = $lang->id;
                    $notifyTemplate->short_name = $lang->short_name;
                    $notifyTemplate->save();
                }

                if (0 == $checkTemplate) {
                    $template = new  NotifyTemplate();
                    $template->language_id = $lang->id;
                    $template->name = $notifyTemplate->name;
                    $template->template_key = $notifyTemplate->template_key;
                    $template->body = $notifyTemplate->body;
                    $template->short_keys = $notifyTemplate->short_keys;
                    $template->status = $notifyTemplate->status;
                    $template->lang_code = $lang->short_name;
                    $template->save();
                }
            }
        }

        $templates = NotifyTemplate::where('template_key', $notifyTemplate->template_key)->with('language')->get();
        return view('admin.pushNotify.edit', compact('notifyTemplate', 'languages', 'templates'));
    }
	

    public function update(Request $request, NotifyTemplate $notifyTemplate, $id)
    {
        $templateData = Purify::clean($request->all());

        $rules = [
            'body' => 'sometimes|required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $template = NotifyTemplate::findOrFail($id);
        $allTemplates = NotifyTemplate::where('template_key', $template->template_key)->get();
        if ($allTemplates) {
            foreach ($allTemplates as $temp) {
                $temp->firebase_notify_status = $templateData['status'];
                $temp->save();
            }
        }

        $template->firebase_notify_status = $templateData['status'];
        $template->body = $templateData['body'];
        $template->save();

        return back()->with('success', 'Update Successfully');
    }



	//---- not used/required here ----//
	public function notifyConfig()
    {
        $control = FirebaseNotify::firstOrNew();
        return view('admin.pushNotify.controls', compact('control'));
    }

    public function notifyConfigUpdate(Request $request)
    {
        $reqData = Purify::clean($request->except('_token', '_method'));
        $request->validate([
            'server_key' => 'required|string',
            'vapid_key' => 'required|string',
            'api_key' => 'required|string',
            'auth_domain' => 'required|string',
            'project_id' => 'required|string',
            'storage_bucket' => 'required|string',
            'messaging_sender_id' => 'required|string',
            'app_id' => 'required|string',
            'measurement_id' => 'required|string',
        ]);

        $control = FirebaseNotify::firstOrNew();
        $control->server_key = $reqData['server_key'];
        $control->vapid_key = $reqData['vapid_key'];
        $control->api_key = $reqData['api_key'];
        $control->auth_domain = $reqData['auth_domain'];
        $control->project_id = $reqData['project_id'];
        $control->storage_bucket = $reqData['storage_bucket'];
        $control->messaging_sender_id = $reqData['messaging_sender_id'];
        $control->app_id = $reqData['app_id'];
        $control->measurement_id = $reqData['measurement_id'];
        $control->user_foreground = $reqData['user_foreground'];
        $control->user_background = $reqData['user_background'];
        $control->admin_foreground = $reqData['admin_foreground'];
        $control->admin_background = $reqData['admin_background'];

        $this->writeGolobalFirebase($control);

        $control->save();
        return back()->with('success', 'Updated Successfully.');
    }

    public function writeGolobalFirebase($control)
    {
        $apikey = '"' . $control->api_key . '"';
        $authDomain = '"' . $control->auth_domain . '"';
        $projectId = '"' . $control->project_id . '"';
        $storageBucket = '"' . $control->storage_bucket . '"';
        $messagingSenderId = '"' . $control->messaging_sender_id . '"';
        $appId = '"' . $control->app_id . '"';
        $measurementId = '"' . $control->measurement_id . '"';


        $myfile = fopen("firebase-messaging-sw.js", "w") or die("Unable to open file!");
        $txt = "
        self.onnotificationclick = (event) => {
            if(event.notification.data.FCM_MSG.data.click_action){
               event.notification.close();
               event.waitUntil(clients.matchAll({
                    type: 'window'
               }).then((clientList) => {
                  for (const client of clientList) {
                      if (client.url === '/' && 'focus' in client)
                          return client.focus();
                      }
                  if (clients.openWindow)
                      return clients.openWindow(event.notification.data.FCM_MSG.data.click_action);
                  }));
            }
        };
        importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
               importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');

        const firebaseConfig = {
        apiKey: $apikey,
        authDomain: $authDomain,
        projectId: $projectId,
        storageBucket: $storageBucket,
        messagingSenderId: $messagingSenderId,
        appId: $appId,
        measurementId: $measurementId
        };

       const app = firebase.initializeApp(firebaseConfig);
       const messaging = firebase.messaging();

       messaging.setBackgroundMessageHandler(function (payload) {
       if (payload.notification.background && payload.notification.background == 1) {
          const title = payload.notification.title;
          const options = {
            body: payload.notification.body,
            icon: payload.notification.icon,
          };
          return self.registration.showNotification(
            title,
            options,
          );
       }
        });";
        fwrite($myfile, $txt);
        fclose($myfile);

        return 0;
    }

}
