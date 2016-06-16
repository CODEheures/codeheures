<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\Auth\AuthController;
use App\User;
use App\Announce;
use Illuminate\Support\Facades\Auth;

class UserTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */

    public function setUp() {
        parent::setUp();
        Artisan::call('migrate');

        User::unguard();
        $this->mailer = Mailer::class;
    }

    public function tearDown() {
        Artisan::call('migrate:rollback');
        parent::tearDown();
    }

    public function defUser(){
        $user[0] = [
            'name' => 'admin',
            'email' => 'webmaster@codeheures.fr',
            'password' => '000000',
            'password_confirmation' => '000000',
        ];
        $user[1] = [
            'name' => 'sylvain2',
            'email' => 'webmaster2@codeheures.fr',
            'password' => '000000',
            'password_confirmation' => '000000',
        ];
        $user[2] = [
            'name' => 'sylvain3',
            'email' => 'webmaster3@codeheures.fr',
            'password' => '000000',
            'password_confirmation' => '000000',
        ];

        return $user;
    }

    public function createConfirmedUser() {
        $users = $this->defUser();

        //creer 2 user
        $this->withoutMiddleware();
        foreach($users as $user) {
            $this->call('POST', route('register.post'), $user);
        }
        $this->assertCount(count($users),User::all());

        $getUsers = User::all();
        foreach($getUsers as $user) {
            $this->call('GET',route('account.confirm', ['id' => $user->id, 'token' => $user->confirmation_token]));
        }

        $this->assertCount(count($users),User::where('confirmed', true)->get());
    }

    public function defAnnounce() {
        $announce[0] = [
            'title' => 'announce0',
            'description' => 'lorem ipsum',
            'price' => '100',
        ];

        return $announce;
    }

    public function testUserCreate() {
        $user = $this->defUser();

        $this->withoutMiddleware();
        $this->call('POST', route('register.post'), $user[0]);
        //$this->assertEquals(200, $response->status());
        $this->assertCount(1,User::all());
        $this->assertCount(0,User::where('confirmed', true)->get());

        $user = User::first();
        //dd(route('account.confirm', ['id' => $user->id, 'token' => $user->confirmation_token]));
        $this->call('GET',route('account.confirm', ['id' => $user->id, 'token' => $user->confirmation_token]));
        $this->assertCount(1,User::where('confirmed', true)->get());

    }

    public function testUserCanLogin() {
        //creer 2 user, valider le 1er et tester leur access login

        $user = $this->defUser();

        //creer 2 user
        $this->withoutMiddleware();
        $this->call('POST', route('register.post'), $user[0]);
        $this->call('POST', route('register.post'), $user[1]);

        //valider le 1er compte
        $getUser = User::first();
        $this->call('GET',route('account.confirm', ['id' => $getUser->id, 'token' => $getUser->confirmation_token]));
        $this->assertCount(1,User::where('confirmed', true)->get());

        //valider qu'il est logué puis logout puis valider logout
        $this->assertTrue(Auth::user()->id == 1);
        Auth::logout();
        $this->assertFalse(Auth::check());

        //choisir un user non confirmed => login => false
        $this->call('POST',route('login.post', ['name' => $user[1]['name'], 'password' => $user[1]['password']]));
        $this->assertFalse(Auth::check());

        //choisir un user confirmed => login => true
        $this->call('POST',route('login.post', ['name' => $user[0]['name'], 'password' => $user[0]['password']]));
        $this->assertTrue(Auth::check());
    }

}
