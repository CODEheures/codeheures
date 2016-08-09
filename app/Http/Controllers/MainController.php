<?php

namespace App\Http\Controllers;


use App\Common\DemoManager;
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

    public function redirectHome() {
        return redirect('/',301);
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

    public function demoCustomerSpace(Request $request) {
        $demoManager = new DemoManager($request->ip());
        $user = $demoManager->getUser();
        auth()->login($user);

        $diff = env('DEMO_VALIDITY')-Carbon::now()->diffInMinutes($user->created_at);

        return redirect(route('customer.monitor.index'))
            ->with('info', 'Bienvenue dans l\'espace client de démonstration. Toutes les actions sont sans engagement et
                ce compte fictif sera detruit dans '. $diff . 'minute(s)');
    }

    public function realisations() {
        return view('realisations.index');
    }

    public function cgv() {
        return view('legal.cgv.index');
    }

    public function mentions() {
        return view('legal.mentions.index');
    }
}
