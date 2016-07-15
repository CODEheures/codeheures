<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Mail\Mailer;

class TestController extends Controller
{
    /**
     * @var Mailer
     */
    private $mailer;
    private $vars;

    /**
     * @param Mailer $mailer
     */
    public function __construct(Mailer $mailer){
        $this->middleware('admin');
        $this->mailer = $mailer;
        $this->vars = ['hello', 'mon pote','1A'];
    }


    public function testMail(Array $vars = []) {

        if(is_array($this->vars) && count($this->vars) > 0){
            $vars = $this->vars;
        }

        $this->mailer->send(['text' => 'emails.test.text', 'html' => 'emails.test.html'],compact('vars'), function($message) {
            $message->to('essai@destockeurope.fr');
            $message->from('webmaster@destockeurope.fr');
            $message->subject('Confirmez votre compte ' . env('APP_NAME'));
        });
        return redirect('/')->with('info', 'mail de test envoyé');
    }
}
