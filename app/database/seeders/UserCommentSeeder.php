<?php

namespace Database\Seeders;

use Api\Modules\UserComment\Models\UserComment;
use Illuminate\Database\Seeder;

class UserCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserComment::factory(40)->create();
    }
}
