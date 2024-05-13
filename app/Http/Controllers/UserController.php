<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserEditRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         abort_if(Gate::denies('user_index'), 403);

        $users =User::paginate(5);

        return view ('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         abort_if(Gate::denies('user_create'), 403);

        $roles = Role::all()->pluck('name', 'id'); // para enlistar los roles
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        $user = User::create($request->only('name', 'email')
                +[
                    'password'=>bcrypt ($request->input ('password')),
                ]);
                // Esto es para guardar los roles
        $roles = $request->input('roles', []);
        $user->syncRoles($roles);

        return redirect()->route('users.index')->with('success','Usuario creado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
         abort_if(Gate::denies('user_show'), 403);
        //$user = User::findOrFail($id);
        //dd($user);
        //$user = User::find($id);
        $user->load('roles');  /* pasa los roles */
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
         abort_if(Gate::denies('user_edit'), 403);
        $roles=Role::all()->pluck('name', 'id');
        $user->load('roles');

        return view('users.edit',compact('user','roles'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserEditRequest $request, User $user)
    {
        // $user=User::findOrFail($id);
        $data =$request->only('name','email');
        $password = $request->input ('password');
        if($password)
            $data['password']= bcrypt($password);
      /*   if(trim($request->passoword)=='')
        {
            $data = $request->except('password');
        }
        else{
            $data=$request->all();
            $data['password']=bcrypt($request->passoword);
        } */

        $user->update($data);

        $roles = $request->input('roles', []);   /* es para los roles */
        $user->syncRoles($roles);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_destroy'), 403); 

        if (auth()->user()->id == $user->id) { /*  para que no se elimine a si mismo */
            return redirect()->route('users.index');
        }

        $user->delete();
        return back()->with('success', 'Usuario Eliminado Corectamente');
    }
}
