<?php

namespace Database\Seeders;

use App\Enums\DemoRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

/**
 * Rollen user/partner/admin und je ein Demo-Konto. Die Passwörter sind
 * zufällig und werden nirgends angezeigt – angemeldet wird nur über die
 * Ein-Klick-Login-Route.
 */
class DemoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach (DemoRole::cases() as $role) {
            Role::findOrCreate($role->value, 'web');

            $user = User::updateOrCreate(
                ['email' => $role->email()],
                [
                    'name' => "Demo {$role->label()}",
                    'password' => Str::random(40),
                    'email_verified_at' => now(),
                ],
            );

            $user->syncRoles([$role->value]);
        }
    }
}
