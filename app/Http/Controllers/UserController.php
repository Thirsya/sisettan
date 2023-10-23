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
        $user = $request->input('user');

        $query = User::select(
            'users.id',
            'users.username',
            // 'users.id_pejabat',
            // 'users.password',
            // 'users.hk',
            'pejabats.nama_pejabat',
            'pejabats.nip_pejabat',
            'pejabats.no_sk'
        )
            ->leftJoin('profiles', 'profiles.id_user', '=', 'users.id')
            ->leftJoin('pejabats', 'pejabats.id', '=', 'profiles.id_pejabat')
            // ->leftJoin('pejabats', 'users.id_pejabat', '=', 'pejabats.id')
            ->when($request->input('user'), function ($query, $user) {
                return $query->where('users.user', 'like', '%' . $user . '%');
            })
            ->when($request->input('pejabat'), function ($query, $pejabat) {
                return $query->whereIn('users.id_pejabat', $pejabat);
            })
            ->whereNull('users.deleted_at')
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
            'password' => Hash::make($request['password']),
        ]);
        return redirect(route('user.index'))->with('success', 'Data Berhasil Ditambahkan');;
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
        //delete data
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User Deleted Successfully');
    }

    public function export()
    {
        // export data ke excel
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function import(Request $request)
    {
        // import excel ke data tables
        $users = Excel::toCollection(new UsersImport, $request->import_file);
        foreach ($users[0] as $user) {
            User::where('id', $user[0])->update([
                'name' => $user[1],
                'email' => $user[2],
                'password' => $user[3],
            ]);
        }
        return redirect()->route('user.index');
    }
}
