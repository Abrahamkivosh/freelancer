<?php

namespace App\Console\Commands;

use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Admin User';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->ask('Enter full name');
        $email = $this->ask('Enter the admin Email address');
        $password = $this->secret('Enter the admin\'s password?');
        $passwordConfirm = $this->secret('Re-enter the admin\'s password?');

        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $passwordConfirm,
        ],[
            'name' => ['required','string', 'min:4', 'max:40'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if ($validator->fails()) {
            $this->info('The Admin account has not been created, validation failed. See the error messages below:');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'email_verified_at' => Carbon::now(),
                'role_id' =>1,
                'password' => Hash::make($password),
            ]);

        } catch (\Exception $exception) {
            DB::rollBack();
            $this->info('The account has not been created. see below the error:');
            $this->error($exception->getMessage());
        }
        DB::commit();

        $this->info('Successfully created the Administrator account');
        return 0;
    }
}
