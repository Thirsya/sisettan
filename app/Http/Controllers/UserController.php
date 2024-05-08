<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Models\Category;
use App\Models\Pejabat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:user.index')->only('index');
        $this->middleware('permission:user.create')->only('create', 'store');
        $this->middleware('permission:user.edit')->only('edit', 'update');
        $this->middleware('permission:user.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pejabats = Pejabat::all();
        $userName = $request->input('user');
        $pejabatIds = $request->input('pejabat');
        $user = $request->input('username');

        $query = User::withTrashed()
            ->select(
                'users.id',
                'users.username',
                'users.username',
                'users.deleted_at',
                'pejabats.nama_pejabat',
                'pejabats.nip_pejabat',
                'pejabats.no_sk'
            )
            ->leftJoin('profiles', 'profiles.id_user', '=', 'users.id')
            ->leftJoin('pejabats', 'pejabats.id', '=', 'profiles.id_pejabat')
            // ->leftJoin('pejabats', 'users.id_pejabat', '=', 'pejabats.id')
            ->when($request->input('username'), function ($query, $user) {
                return $query->where('users.username', 'like', '%' . $user . '%');
            })
            ->when($request->input('pejabat'), function ($query, $pejabat) {
                return $query->whereIn('users.id_pejabat', $pejabat);
            })
            ->paginate(10);
        $pejabatSelected = $request->input('pejabat');

        $query->appends(['user' => $userName, 'pejabat' => $pejabatIds]);

        return view('users.index')->with([
            'users' => $query,
            'pejabats' => $pejabats,
            'userName' => $userName,
            'pejabatIds' => $pejabatIds,
            'pejabatSelected' => $pejabatSelected,
            'user' => $user,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // halaman tambah user
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        //simpan data
        User::create([
            'name' => $request['name'],
            'username' => $request['username'],
            'password' => Hash::make($request['password']),
        ]);
        return redirect(route('user.index'))->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //nampilkan detail satu user
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit')
            ->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //mengupdate data user ke database
        $validate = $request->validated();

        $user->update($validate);
        return redirect()->route('user.index')->with('success', 'User Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User Deleted Successfully');
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->where('id', $id)->first();
        $user->restore();
        return redirect()->route('user.index')->with('success', 'User Diaktifkan');
    }
}
