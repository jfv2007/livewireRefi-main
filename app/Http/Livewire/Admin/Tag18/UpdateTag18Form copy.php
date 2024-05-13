<?php

namespace App\Http\Livewire\Admin\Tag18;

use App\Models\Categoria;
use App\Models\Centro;
use App\Models\Planta;
use App\Models\Seccion;
use App\Models\Stag;
use App\Models\Tag18;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateTag18Form extends Component
{
    use WithFileUploads;
    public $state =[];
    /* public $selectedCentro; */
    public $selectedCentro =NULL;
    public $selectedPlanta = NULL;
    public $foto;
    public $foto1;
    public $identificador;
    public $centros;

    public $search;
    public $messaje = 'Para mostrar';
    public $readyToLoad = true;


    public function mount(Tag18 $tag18)
    {

        /* se pasan los valores a los combos */

         /*  $this->tag18 = $tag18; */
       /*   dd($tag18); */
        $this->state = $tag18->toArray();
        $this->selectedCentro = $this->state['id_cen'];
        $this->selectedPlanta= $this->state['id_planta'];

        /* dd($this->selectedPlanta); */

        $this->selectedSeccion = $this->state['id_seccion'];
        $this->selectedCategoria=$this->state['id_categoria'];
        $this->selectedStatus =$this->state['id_status'];
         $this->foto = $this->state['foto'];


         $this->centros=Centro::all();
         $this->plantas =Planta::all();
        $this->seccions = Seccion::all();
        $this->categorias = Categoria::all();
        $this->status = Stag::all();
         $this->identificador= rand();

        /* $validateDate['foto'] = $this->foto->store('/', 'planta'); */
        /* $selectedSeccion= $id_seccion;*/

/*  dd($this->selectedPlanta); */
    }

    public function updatedselectedCentro($centro)
    {
         $this->plantas = Planta::where('id_centro', $centro)->get();
    }
    public function edit(Tag18 $tag18)
    {
        $this->reset();
    }

    public function updateTag()
    {
         /* dd($this->state['id']);  regresa el tag*/
/*
        $identica= $this->state['tag'];
        dd($this->$identica);
 */
         $registro =Tag18::findOrFail($this->state['id']); /* regresa todo el registro completo */


         /* dd($this->$registro); */

         /* $validateDate = $this->validate(); */

         $validateDate= Validator::make(
            $this->state,
            [
                'tag'=>'required',
                'descripcion'=>'required',
                'operacion'=>'required',
                'ubicacion'=>'required',
             ],
             [
                'tag.required' => 'El tag es requerido.',
                'descripcion.required' =>  'La descripcion es requerida'
             ]
             )->validate();

              $validateDate['id_cen'] = $this->selectedCentro;
             $validateDate['id_planta']=$this->selectedPlanta;
             $validateDate['id_seccion']=$this->selectedSeccion;
             $validateDate['id_categoria']=$this->selectedCategoria;
             $validateDate['id_status']=$this->selectedStatus;

             /* $previousPath = $this->foto; /* foto antigua */

               /* dd($previousPath); */
               /* $validateDate['foto'] = $this->state['tag']->store('/', 'planta'); */
               /* $path = $this->state['foto']->store('/', 'planta'); */
               /*$path = $this->image->store('/', 'avatars');   /* busca el nombre */

               $filename = "";
                $destination=public_path('storage\\'.$registro->foto);
               /* $destination =$this->state['foto']->store('/', 'planta'); */

              /*  store('/', 'planta') */
              /*  dd($destination); */
              /* dd($path); */


        /*  $destination=public_path('storage\\'.$images->images); */
        /*  dd($destination); */
        /* dd($this->foto1); */
        if ($this->foto1 != null) {
            if(File::exists($destination)){
                File::delete($destination);
            }
            $filename = $this->foto1->store('/', 'planta');
        } else {
            $filename = $this->state['foto'];
        }
       /*  dd($filename); */

        $registro->tag = $this->state['tag'];
        $registro->descripcion =$this->state['descripcion'];
        $registro->operacion=$this->state['operacion'];
        $registro->ubicacion=$this->state['ubicacion'];
        $registro->id_cen=$this->selectedCentro;
        $registro->id_planta=$this->selectedPlanta;
        $registro->id_seccion=$this->selectedSeccion;
        $registro->id_categoria=$this->selectedCategoria;
        $registro->id_status=$this->selectedStatus;

       /*  dd($registro->id_cen); */

        $registro->foto = $filename;
        $result = $registro->save();

             /* $registro->update(['foto' => $destination]);
 */
             /* Storage::disk('planta')->delete($previousPath); */

             $this->dispatchBrowserEvent('updated', ['message' => 'Profile changed successfully!']);

/*
             return back();*/
             
            return redirect()->back();
            $this->emitTo('list-tag18s', 'render');


            /* return view('livewire.admin.tag18.list-tag18s',compact('tag18s')); */



            /*  return redirect()->route('admin.tag18s'); */
            /* Tag18::create($validateDate); */



            /* imagen usuario
            $previousPath = auth()->user()->avatar;
            /* dd($previousPath);
            $path = $this->image->store('/', 'avatars');
            /* dd($path);
            auth()->user()->update(['avatar' => $path]);
             Storage::disk('avatars')->delete($previousPath);
            $this->dispatchBrowserEvent('updated', ['message' => 'Profile changed successfully!']);
 */
    }

    public function render()
    {
        $tag18s =Tag18::all();
        return view('livewire.admin.tag18.update-tag18-form', [
            'tag18' => $tag18s,
        ]);
    }
}
