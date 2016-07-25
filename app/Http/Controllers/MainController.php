<?php

namespace App\Http\Controllers;


use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\ContactRequest;
use App\Http\Controllers\Controller;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\URL;

class MainController extends Controller
{
    private $mailer;

    public function __construct(Mailer $mailer) {
        $this->mailer = $mailer;
    }

    public function index() {
        return view('Index.index');
    }

    public function contact_post(ContactRequest $request) {
        $data = $request->only('email', 'content');

        $this->mailer->send(['text' => 'emails.contact.text-contact', 'html' => 'emails.contact.html-contact'], compact('data'), function($message) {
            $message->to(env('MAIL_USERNAME'));
            $message->subject('Un nouveau message en provenance du site ' . env('APP_NAME'));
        });

        return redirect()->to(URL::previous() . "#contact")->with('success', 'Merci, votre mail est envoyé. Nous vous répondrons dans les plus brefs délais');
    }

    public function demoCustomerSpace() {
        $user = User::where('email', '=', env('DEMO_USER_MAIL'))->first();
        auth()->login($user);

        $diff = 60 - Carbon::now()->minute;

        return redirect(route('customer.monitor.index'))
            ->with('info', 'Bienvenue dans l\'espace client de démonstration.
                Prochaine régération dans '. $diff . 'minute(s)');
    }

    public function cgv() {
        return view('legal.cgv.index');
    }

    public function mentions() {
        return view('legal.mentions.index');
    }
}
