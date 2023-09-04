<?php

namespace App\Http\Controllers;

use App\Models\Profile;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Pejabat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class ProfileController extends Controller
{
    public function index()
    {
        $users = User::all();
        $pejabat = DB::table('pejabats')
            ->select(
                'pejabats.id',
                'pejabats.nama_pejabat',
                'pejabats.id_jabatan',
                'pejabats.id_opd',
                'pejabats.nip_pejabat',
                'pejabats.no_sk',
                'opds.id as opds_id',
                'opds.id_kecamatan',
                'jabatans.jabatan',
            )
            ->leftJoin('jabatans', 'pejabats.id_jabatan', '=', 'jabatans.id')
            ->leftJoin('opds', 'pejabats.id_opd', '=', 'opds.id')
            ->whereNull('pejabats.deleted_at')
            ->get();

        $profiles = DB::table('profiles')
            ->select(
                'profiles.id',
                'profiles.id_user',
                'profiles.id_pejabat',
                'profiles.hk',
                'pejabats.id_jabatan',
                'pejabats.id_opd',
                'pejabats.nama_pejabat',
                'pejabats.nip_pejabat',
                'pejabats.no_sk',
                'users.remember_token',
            )
            ->leftJoin('users', 'profiles.id_user', '=', 'users.id')
            ->leftJoin('pejabats', 'profiles.id_pejabat', '=', 'pejabats.id')
            ->paginate(10);

        $currentUserId = Auth::user()->id;
        $profilesCollection = collect($profiles->items());
        $currentProfile = $profilesCollection->firstWhere('id_user', $currentUserId);
        $currentIdPejabat = $currentProfile ? $currentProfile->id_pejabat : null;

        return view('profile.index')->with([
            'profiles' => $profiles,
            'users' => $users,
            'pejabat' => $pejabat,
            'currentIdPejabat' => $currentIdPejabat,
            'currentProfile' => $currentProfile,
        ]);
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'id_pejabat' => 'required|integer',
            'hk' => 'required|integer',
        ]);

        $user = Auth::user();
        $userId = $user->id;

        $user->username = $validatedData['username'];
        $user->name = $validatedData['name'];
        $user->save();

        $profile = Profile::firstOrNew(['id_user' => $userId]);
        $profile->id_pejabat = $validatedData['id_pejabat'];
        $profile->hk = $validatedData['hk'];
        $profile->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
