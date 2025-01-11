<?php

use App\Models\Post;
use App\Models\User;

test('auth user can write a post', function () {
    $user = User::latest()->first();
    $body = fake()->realText();
    $response = $this->actingAs( $user )->post('/posts', [
        'body' => $body,
        'user_id' => $user->id,
    ]);
    $this->assertDatabaseHas('posts', ['body' => $body]);
});

test('random auth user can write a new post and can see to his feeds', function () {
    $user = User::inRandomOrder()->first();
    $body = fake()->sentence();
    $response = $this->actingAs( $user )->post('/posts', [
        'body' => $body,
        'user_id' => $user->id,
    ]);
    
    $view = $this->view('posts.index', ['posts' => Post::where('user_id', '=', $user->id)->get()]); 
    $view->assertSee( $body );
});