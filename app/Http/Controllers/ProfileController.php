<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:profile.index')->only('index');
        $this->middleware('permission:profile.create')->only('create', 'store');
        $this->middleware('permission:profile.edit')->only('edit', 'update');
        $this->middleware('permission:profile.destroy')->only('destroy');
    }

    public function index(Request $request)
    {
        $users = User::all();
        $name = $request->input('name');
        $profiles = DB::table('profiles')
            ->select(
                'profiles.id',
                'profiles.id_user',
                'profiles.idfk_pejabat',
                'profiles.hk',
                'pejabats.id_jabatan',
                'pejabats.id_opd',
                'pejabats.nama_pejabat',
                'pejabats.nip_pejabat',
                'pejabats.no_sk',
                'users.username',
                'users.name',
                'users.email',
                'users.email_verified_at',
                'users.password',
                'users.two_factor_secret',
                'users.two_factor_recovery_codes',
                'users.two_deleted_at',
                'users.remember_token',
            )
            ->leftJoin('users', 'profiles.id_user', '=', 'users.id')
            ->leftJoin('pejabats', 'profiles.id_pejabat', '=', 'pejabats.id')
            ->when($request->input('nama_pejabat'), function ($query, $nama_pejabat) {
                return $query->where('nama_pejabat', 'like', '%' . $nama_pejabat . '%');
            })
            ->when($request->input('username'), function ($query, $username) {
                return $query->whereIn('daerah.jenis_barang_id', $username);
            })
            ->paginate(10);
        $userSelected = $request->input('username');
        return view('profile.index')->with([
            'profiles' => $profiles,
            'users' => $users,
            'userSelected' => $userSelected,
            'name' => $name,
        ]);
    }

    public function create()
    {
        //
    }

    public function store(StoreProfileRequest $request)
    {
        //
    }

    public function show(Profile $profile)
    {
        //
    }

    public function edit(Profile $profile)
    {
        //
    }

    public function update(UpdateProfileRequest $request, Profile $profile)
    {
        //
    }

    public function destroy(Profile $profile)
    {
        //
    }
}
