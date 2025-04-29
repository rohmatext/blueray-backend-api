<?php

namespace App\Console\Commands;

use App\Enums\RolesEnum;
use App\Models\User;
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
    protected $description = 'Create an admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $input = collect([
            'name' => null,
            'email' => null,
        ]);

        do {
            $input->put('name', $this->ask('Name', $input->get('name')));
            $input->put('email', $this->ask('Email', $input->get('email')));

            $validator = Validator::make($input->toArray(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:users,email'],
            ]);

            if ($validator->fails()) {
                $this->error("\nThere were some issues with your input:");

                foreach ($validator->errors()->messages() as $field => $messages) {
                    foreach ($messages as $message) {
                        $this->error("- {$message}");
                    }
                }

                $this->line("\nPlease correct the errors above.\n");
            }
        } while ($validator->fails());

        try {
            DB::beginTransaction();
            $user = User::create($input->merge([
                'password' => Hash::make('password')
            ])->toArray());
            $user->assignRole(RolesEnum::ADMIN->value);
            DB::commit();

            $this->info("\nUser {$user->name} created successfully!");
            $this->line(str_repeat('=', 30));
            $this->line("Email    : {$user->email}");
            $this->line("Password : password");
            $this->line(str_repeat('=', 39));
            $this->info("Please make sure to save this information safely.");
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("\nAn error occurred while creating the user: {$e->getMessage()}");
            $this->error("Please try again.");
        }
    }
}
