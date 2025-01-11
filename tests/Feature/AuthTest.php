<?php

use Tests\TestCase;
use App\Models\User;
use function Pest\Faker\fake;
use Illuminate\Http\Response;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use Illuminate\Support\Facades\Hash;

test('if anonymous user tries to access home page, it redirects to login window', function () {
    $response = $this->get('/');    
    $response->assertStatus(302);
});

test('authenticated user can view a home page after logged in', function(){
    $user = User::factory()->create();
    $response = $this->actingAs( $user )->get('/login');
    $response->assertRedirect( route('home') );    
});

test('user can reach login window', function () {
    $response = $this->get('/login');    
    $response->assertStatus(200);
});

it('has error if the details are not provided', function () {
    
    $this->post( '/register' )
        ->assertSessionHasErrors(['fullname', 'username', 'email', 'password']);    
});

it('has login form error if the details are not provided', function () {
    
    $this->post( '/login' )
        ->assertSessionHasErrors(['email', 'password']);    
});

test('user can register and redirect to login page', function () {
    $username = fake()->name;
    $email = fake()->email;
    $this->post( '/register', [
        'fullname' => fake()->name,
        'username' => $username,
        'email' => $email,
        'password' => 'password',
    ])
    ->assertValid()
    ->assertRedirect('/login');
    $this->assertDatabaseHas('users', ['username' => $username, 'email' => $email]);
});

test('user can authenticate and redirect to home page', function () {
    
    $user = User::factory()->create();
    $response = $this->post( '/login', [
        'email' => $user->email,
        'password' => 'password',
    ])
    ->assertValid()
    ->assertRedirect('/home');
    $this->assertAuthenticated();
});

test('user can not login with invalid credentials', function () {
    
    $response = $this->post(route('login'), [
        'email' => 'hasan@hafiz.com',
        'password' => 'password'
    ]);
    
    $view = $this->view('login');
    $view->assertSeeText('Either Username or Password is Invalid.');
});