<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService
{
    public function create(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function getAllUsers(): LengthAwarePaginator
    {
        return User::query()
            ->select(['id', 'name', 'email', 'created_at'])
            ->paginate(15);
    }
    public function getUserById(int $id): ?User
    {
        return User::find($id);
    }

    public function update(User $user, array $data): User
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return $user->refresh();
    }
    public function delete(User $user): bool
    {
        return (bool) $user->delete();
    }
}
