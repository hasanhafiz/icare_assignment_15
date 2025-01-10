<?php

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Faker\fake;


test('user can not view a login form when authenticated', function(){
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

test('user can register and redirect to login page', function () {
    $username = fake()->name;
    $email = fake()->email;
    $this->post( '/register', [
        'fullname' => fake()->name,
        'username' => $username,
        'email' => $email,
        'password' => 'password',
    ])
    ->assertRedirect('/login');
    $this->assertDatabaseHas('users', ['username' => $username, 'email' => $email]);

});

test('user can authenticate and redirect to home page', function () {
    
    $user = User::factory()->create();
    // // dump( $user );
    
    $response = $this->post( '/login', [
        'email' => $user->email,
        'password' => 'password',
    ])
    ->assertRedirect('/home');
    $this->assertAuthenticated();
});