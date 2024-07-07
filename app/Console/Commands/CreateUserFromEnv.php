<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUserFromEnv extends Command
{
    protected $signature = 'make:envuser';
    protected $description = 'Create or update a user from the environment variables';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $username = config('custom_auth.user');
        $password = config('custom_auth.password');

        $user = User::where('email', $username)->first();

        if ($user) {
            $user->password = Hash::make($password);
            $user->save();
            $this->info('User password updated successfully for username: ' . $username);
        } else {
            User::create([
                'name' => $username,
                'email' => $username,
                'password' => Hash::make($password),
            ]);
            $this->info('User created successfully with username: ' . $username);
        }
    }
}
