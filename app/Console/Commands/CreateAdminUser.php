<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@smilepro.nl'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        if ($admin->wasRecentlyCreated) {
            $this->info('Admin user created successfully!');
        } else {
            $this->info('Admin user already exists!');
        }
        
        $this->info('Email: admin@smilepro.nl');
        $this->info('Password: admin123');
        $this->info('Role: admin');
    }
}
