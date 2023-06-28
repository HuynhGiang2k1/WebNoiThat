<?php

namespace App\Repository;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    private $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function getUsers($request)
    {
        return $this->model
            ->when($request->id, function ($q) use ($request) {
                return $q->where('id', $request->id);
            })
            ->when($request->name, function ($q) use ($request) {
                return $q->where('name', 'like', '%'.$request->name.'%');
            })
            ->when($request->email, function ($q) use ($request) {
                return $q->where('email', 'like', '%'.$request->email.'%');
            })
            ->when($request->status, function ($q) use ($request) {
                if (in_array(1, $request->status)) {
                    $q->orWhereNotNull('email_verified_at');
                }
                if (in_array(2, $request->status)) {
                    $q->orWhereNull('email_verified_at');
                }
            })
            ->whereNull('is_admin')
            ->paginate(10);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function getUser($id)
    {
        return $this->model->findOrFail($id);
    }

    public function updateUser($id, $data)
    {
        return $this->model
            ->where('id', $id)
            ->update($data);
    }

    public function deleteUser($id)
    {
        return $this->model->where('id', $id)->delete();
    }

    public function getUserByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function countUsers()
    {
        return $this->model->whereNull('deleted_at')->count();
    }

    public function countUserByMonth()
    {
        return $this->model
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', '=', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }
}
