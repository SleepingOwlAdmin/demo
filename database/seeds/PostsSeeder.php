<?php

use Faker\Factory;
use App\Model\Post;
use Illuminate\Database\Seeder;

class PostsSeeder extends Seeder
{

    public function run()
    {
        Post::truncate();

        factory(Post::class, 50)->create()->each(function(Post $post) {
            if (mt_rand(0, 10) < 3) {
                $post->delete();
            }
        });
    }

}
