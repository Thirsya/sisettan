<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Daerah;
use App\Models\Tahun;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|name',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('name', $request->name)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'name' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json(
            [
                'token' => $user->createToken($request->device_name)->plainTextToken,
            ],
            200
        );
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => ['required', 'string', 'min:8', 'confirmed', Password::defaults()],
            'device_name' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(
            [
                'token' => $user->createToken($request->device_name)->plainTextToken,
            ],
            200
        );
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response()->noContent();
    }

    public function requestAjaxLogin(Request $request)
    {
        if ($request->ajax() && $request->has('tahun_id')) {
            $tahunId = $request->input('tahun_id');

            $daerahs = Daerah::select(
                'daerahs.id',
                'daerahs.tanggal_lelang',
                'daerahs.id_kelurahan',
                'daerahs.id_kecamatan',
                'kelurahans.kelurahan',
                'kecamatans.kecamatan as kecamatan',
            )
                ->leftJoin('kecamatans', 'daerahs.id_kecamatan', '=', 'kecamatans.id')
                ->leftJoin('kelurahans', 'daerahs.id_kelurahan', '=', 'kelurahans.id')
                ->whereYear('daerahs.tanggal_lelang', '=', $tahunId)
                ->get();
            return response()->json($daerahs);
        }
    }
}
