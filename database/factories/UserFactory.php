<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'role' => fake()->randomElement(['admin', 'petugas', 'pimpinan']),
            'department' => fake()->randomElement([
                'Administrasi', 'IT', 'Keuangan', 'HRD', 'Operasional', 'Marketing'
            ]),
            'position' => fake()->randomElement([
                'Staff', 'Supervisor', 'Manager', 'Assistant Manager', 'Koordinator'
            ]),
            'phone' => fake()->phoneNumber(),
            'is_active' => true,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Create admin user
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'department' => 'IT',
            'position' => 'System Administrator',
        ]);
    }

    /**
     * Create pimpinan user
     */
    public function pimpinan(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'pimpinan',
            'department' => 'Direktur',
            'position' => 'Direktur',
        ]);
    }

    /**
     * Create petugas user
     */
    public function petugas(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'petugas',
            'department' => fake()->randomElement(['Administrasi', 'Sekretariat']),
            'position' => 'Staff',
        ]);
    }
}