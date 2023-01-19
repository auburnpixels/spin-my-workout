<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Submission;
use \Illuminate\Http\Request;
use Spatie\Newsletter\Facades\Newsletter;

/**
 * @class HomepageController
 */
class HomepageController extends Controller
{

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $requested = Submission::count();

        $limitSetting = Setting::where('name', 'limit')->first();
        $setting = Setting::where('name', 'allow_submissions')->first();

        return view('homepage.index', compact('setting', 'requested', 'limitSetting'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $allowSubmissionsSetting = Setting::where('name', 'allow_submissions')->first();

        if (!$allowSubmissionsSetting) {
            return back();
        }

        $validated = $request->validate([
            'email' => 'required|email',
            'workout' => 'required',
            'artists' => 'required',
        ]);

        $submissionForEmail = Submission::where('email', $validated['email'])->first();

        if (!is_null($submissionForEmail)) {
            return redirect('#request-your-mix')
                ->with('message', 'You have already requested a mix from this email, and we will only accept one request per email while in beta.');
        }

        Submission::create([
            'email' => $validated['email'],
            'workout' => $validated['workout'],
            'artists' => $validated['artists']
        ]);

        $submissionsCount = Submission::count();
        $limitSetting = Setting::where('name', 'limit')->first();

        if ($submissionsCount >= $limitSetting->value) {
            Setting::where('name', 'allow_submissions')->update(['value' => 0]);
        }

        return redirect('#request-your-mix')
            ->with('message', 'Thank you for requesting your music mix. We strive to get your mix to you as soon as possible.');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        $mailchimp = new \MailchimpMarketing\ApiClient();

        $mailchimp->setConfig([
            'apiKey' => config('services.mailchimp.key'),
            'server' => 'us18'
        ]);

        $member = $mailchimp->searchMembers->search($validated['email']);

        if ($member->exact_matches->total_items == 0) {
            $mailchimp->lists->addListMember(config('services.mailchimp.list'), [
                "email_address" => $validated['email'],
                "status" => "subscribed",
            ]);
        }

        return redirect('/#be-in-the-loop')
            ->with('subscribe_message', 'Thank you for staying the loop. We look forward to providing exciting updates in the near future.');
    }
}
