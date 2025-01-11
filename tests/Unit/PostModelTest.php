<?php

use App\Models\Post;
use App\Models\User;
use Tests\TestCase;

it('it can create a user instance', function () {
    $user = new User([
        'firstname' => 'Hasan',
        'lastname' => 'Hafiz',
        'fullname' => 'Hasan Hafiz',
        'username' => 'hasanhafiz',
        'email' => 'hasanhafiz@gmail.com',
    ]);
    
    expect( $user )
    ->toBeInstanceOf( User::class )
    ->and( $user->username )->toBe( 'hasanhafiz' )->not->toBeNull()
    ->and( $user->email )->toBe( 'hasanhafiz@gmail.com' )
    ->and( $user->email )->toBeString()->toContain('@');
    
    expect( $user->firstname )->not->toContain( ' ' );
     
    expect( $user->email )->toBeEmail();
});