<?php

namespace App\Http\Livewire\Admin\Users;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;

class ListUsers extends AdminComponent
{
    use WithFileUploads;

    public $state = [];
    public $user;
    public $showEditModal = false;
    public $userIdBeingRemoved = null;
    public $searchTerm = null;
    public $photo;

    public function addNew()
    {
        /* dd('hola'); */
        /* $this->state = []; */
        $this->reset();

        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-form');
    }

    public function createUser()
    {
        /* dd('hola'); */
        /* dd($this->photo); */
        /*  dd($this->state); */


        $validateDate = Validator::make($this->state, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            /*  'avatar' => 'required|image|mimes:jpeg,png,svg|max:1024' */
        ])->validate();

        /* dd($validateDate); */
        $validateDate['password'] = bcrypt($validateDate['password']);
        /* dd($this->photo); */

         if ($this->photo) {
            $validateDate['avatar'] = $this->photo->store('/', 'avatars');
        }

        User::create($validateDate);
        /*  session()->flash('message' , 'User added successfully!');  */

        $this->dispatchBrowserEvent('hide-form', ['message' => 'User added successfully!']);

        /* return redirect()->back(); */
    }

    public function edit(User $user)
    {
         /* dd($user);  */
        $this->reset();
        $this->showEditModal = true;
        $this->user = $user;
      /* dd($user->toArray()); */
        $this->state = $user->toArray(); /* recibe los datos */
        $this->dispatchBrowserEvent('show-form');
    }

    public function updateUser()
    {
        /* dd('here'); */
        $validateDate = Validator::make($this->state, [
            'name'=>'required',
            'email'=>'required|email|unique:users,email,'.$this->user->id,
            'password'=>'sometimes|confirmed',
           ])->validate();

           /* dd($validateDate); */
           if(!empty($validateDate['password'])){
            $validateDate['password'] =bcrypt($validateDate['password']);
           }

            if ($this->photo) {
            /*  {{ asset('storage/avatars/' delete($this->avatar) ) }}; */
             Storage::disk('avatars')->delete($this->user->avatar);
            $validateDate['avatar'] = $this->photo->store('/', 'avatars');

            }

           /* dd('done'); */
           $this->user->update($validateDate);

           $this->dispatchBrowserEvent('hide-form', ['message' => 'User updated successfully!']);
          /*  return redirect()->back(); */
        }

        public function confirmUserRemoval($userId){
            /* dd($userID); */
            $this->userIdBeingRemoved =$userId;
            $this->dispatchBrowserEvent('show-delete-modal');

        }

        public function deleteUser(){
            $user =User::findOrfail($this->userIdBeingRemoved);
            $user->delete();
            $this->dispatchBrowserEvent('hide-delete-modal', ['message' => 'User deleted successfully']);
            /* dd($user); */
        }


    public function render()
    {
        /*  dd($this->searchTerm); */
         $users=User::query()
        ->where('name', 'like', '%'.$this->searchTerm.'%')
        ->orWhere('email', 'like', '%'.$this->searchTerm.'%')
        ->latest()->paginate(5);


        $roles =Role::all()->pluck('name', 'id');

        /* dd($roles); */
        /* $users=User::latest()->paginate(5); */


        return view('livewire.admin.users.list-users', [
            'users'=>$users, 'roles'=>$roles
        ]);
    }
}
