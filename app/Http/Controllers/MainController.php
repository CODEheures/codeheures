<?php

namespace App\Http\Controllers;


use App\Http\Requests\ContactRequest;
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
        return view('index');
    }

    public function contact_post(ContactRequest $request) {
        $data = $request->only('email', 'content');

        $this->mailer->send(['text' => 'emails.contact.text-contact', 'html' => 'emails.contact.html-contact'], compact('data'), function($message) {
            $message->to(env('MAIL_USERNAME'));
            $message->subject('Un nouveau message en provenance du site ' . env('APP_NAME'));
        });

        return redirect()->to(URL::previous() . "#contact")->with('success', 'Merci, votre mail est envoyé. Nous vous répondrons dans les plus brefs délais');
    }

    public function realisations() {
        return view('realisations');
    }

    public function cgv() {
        return view('cgv');
    }

    public function mentions() {
        return view('mentionsLegales');
    }
}
