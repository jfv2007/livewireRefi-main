<?php

namespace App\Http\Livewire\Admin\Tag18;

use App\Models\Categoria;
use App\Models\Centro;
use App\Models\Planta;
use App\Models\Seccion;
use App\Models\Stag;
use App\Models\Tag18;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateTag18Form extends Component
{
    use WithFileUploads;

    public $state =[];
    /* public $tag;
   public $descripcion;
   public $operacion;
   public $ubicacion; */
   public $foto;

   public $selectedCentro = 'MIGUEL HIDALGO';
   public $selectedPlanta = NULL;
   public $selectedSeccion = NULL;
   public $selectedCategoria = NULL;
   public $selectedStatus =NULL;

   public function mount()
   {
       $this->centros = Centro::all();
       $this->plantas = collect();
       $this->categorias = Categoria::all();
       $this->status = Stag::all();
   }

   public function updatedselectedCentro($centro)
   {
         /* sleep(2); */
         /* dd($country);  ok*/
        $this->plantas = Planta::where('id_centro', $centro)->get();
       /* $this->planta =$this->plantas->first()->id ??null; */
   }

   public function createTag()
   {
         /* dd($this->selectedSeccion); */
        $validateDate= Validator::make(
           $this->state,
           [
               'tag'=>'required',
               'descripcion'=>'required',
               'operacion'=>'required',
               'ubicacion'=>'required',

            ],
            [
               'tag.required' =>' El tag es requerido.'
               
            ]
            )->validate();

            $validateDate['id_cen'] = $this->selectedCentro;
            $validateDate['id_planta']=$this->selectedPlanta;
            $validateDate['id_seccion']=$this->selectedSeccion;
            $validateDate['id_categoria']=$this->selectedCategoria;
            $validateDate['id_status']=$this->selectedStatus;

             if ($this->foto) {
            $validateDate['foto'] = $this->foto->store('/', 'planta');
          /*   $validateDate['avatar'] = $this->photo->store('/', 'avatars'); */
            }

            Tag18::create($validateDate);

           $this->dispatchBrowserEvent('hide-form', ['message'=>'Tag added successfully!']);

           /*  return redirect()->back(); */
           return redirect()->route('admin.tag18s');
        }


   public function render()
   {
       $seccions = Seccion::all();

       return view('livewire.admin.tag18.create-tag18-form', [
           'seccions'=> $seccions,
       ]);
   }
}
