<?php

use App\Models\Post;
use App\Models\User;

test('example', function () {
    $response = $this->get('/');    
    $response->assertStatus(302);
});

test('auth user can write a post', function () {
    $user = User::latest()->first();
    $body = fake()->realText();
    $response = $this->actingAs( $user )->post('/posts', [
        'body' => $body,
        'user_id' => $user->id,
    ]);
    $this->assertDatabaseHas('posts', ['body' => $body]);
});

test('auth user can write a new post and see his feed', function () {
    $user = User::inRandomOrder()->first();
    $body = fake()->sentence();
    $response = $this->actingAs( $user )->post('/posts', [
        'body' => $body,
        'user_id' => $user->id,
    ]);
    
    $view = $this->view('posts.index', ['posts' => Post::where('user_id', '=', $user->id)->get()]); 
    $view->assertSee( $body );
});