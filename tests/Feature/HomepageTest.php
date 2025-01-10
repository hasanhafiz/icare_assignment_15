<?php

use App\Models\User;

test('it redirects to login page if user is not logged in', function () {
    
    // AAA Rules
    
    // Arrange -> Act -> Assert
    $response = $this->get('/');
    
    $response->assertStatus(302);
});

test('it register a user successfully', function () {
    
    // AAA Rules
    
    // Arrange -> Act -> Assert
    $user = User::factory([ 'fullname' => 'Hasan Hafiz', 'username' => 'hasanhafiz', 'email' => 'hasanhafiz@gmail.com', 'password' => '123456'])->create();
    
    $response->assertStatus(302);
});