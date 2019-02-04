<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\UserRepository;

class LaunchApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:launch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Launches the app with some basic configs';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(UserRepository $userRepository)
    {
        if ($userRepository->adminExists()) {
            $this->error('Admin user already exists');
            die();
        }

        $email = $this->ask('Please insert the admin email');
        $password = $this->secret('Please insert the admin password');
        $userRepository->create([
            'email' => $email,
            'password' => $password, // the password will be crypted via accessors inside the model
            'name' => 'admin',
            'role' => 'admin'
        ]);

        $this->info('Admin created successfully');
    }
}