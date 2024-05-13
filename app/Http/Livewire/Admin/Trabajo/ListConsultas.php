<?php

namespace App\Http\Livewire\Admin\Trabajo;

use App\Models\Centro;
use App\Models\Falla;
use App\Models\Planta;
use App\Models\Strabajo;
use App\Models\Tag18;
use App\Models\Trabajo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ListConsultas extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $centros = [];
    public $plantas =[];
    public $status=[];
    Public $statetrabajo = [];
    public $state = [];

    public $tag18;
    public $tag;
    public $centro;
    public $trabajo;
    public $editFallaModal = false;
    public $falla;
    public $id_tag18s;
    public $descripcionfalla;
    public $selectedStatusModal;
    public $tagnombre;
    public $descripcion;
    public $fallaIdBeingRemoved = null;
    public $foto_falla;

    public $selectedCentroListFallas = NULL;
    public $selectedPlantaListFallas = NULL;


    public function edit(Falla $falla)
    {
           /* dd($falla);   */
        $this->editFallaModal = true;
        /*  dd('hola'); */
        $this->falla = $falla;
        $this->state = $falla->toArray();

        /* dd($this->state);  */

        $this->id_tag18s = $this->state['id_tag18s'];

       /*  $this->descripcionfalla = $this->state['descripcion_falla']; */
        $this->descripcionfalla = $this->state['descripcion_falla'];
        $this->selectedStatusModal = $this->state['id_sfallas'];
        /* dd($this->id_tag18); */

        $tag18 = Tag18::find($this->id_tag18s);
        /*   return $tag18; */
        $tagNombre = $tag18->tag;
        $tagDescripcion = $tag18->descripcion;

        $this->tagnombre = $tagNombre;
        $this->descripcion = $tagDescripcion;
        /* $id_tag18s=$tag18->id; */

        $this->dispatchBrowserEvent('show-formfallaedit');
    }

    public function updateFalla()
    {
            /* dd($this->state); */
            /* dd($this->descripcionfalla); */
        /* if($this->selectedStatusModal==""){
            $this->mensaje= 'Faltan parametros';
            /*  dd($this->mensaje); */
        /*   } */

        $validateDate = Validator::make(
            $this->state,
            [
                'id' => 'required',
                'descripcion_falla' =>  'required',
            ],
            [
                'id.required' => ' El Tag es requerido.',
                'descripcion_falla.required'=> 'La descripcion de la falla es requerida'
            ]
        )->validate();


        /* $this->validate(); */
        /* descripcionfalla */

        $validateDate['descripcion_falla'] = strtoupper($this->descripcionfalla);
        $validateDate['id_sfallas'] = $this->selectedStatusModal;
        /* 3 pendiente atender */
        /*  $validateDate['id_sfallas'] = $this->selectedStatusModalTrabajo; */
        /* dd($this->foto_falla); */
        /*   dd($this->selectedStatusModal); */

        /* COMPARAR SI ES NULLO */
        /* if (is_null($this->foto_falla)) {
            $this->mensaje= 'Faltan parametros';
            /* dd($this->mensaje);*/
        /*   } */


        if ($this->foto_falla != null) {

            $registro = Falla::findOrFail($this->state['id']); /* regresa todo el registro completo */

            /* dd($registro);  */
            $filename = "";
            $nombreArchivo = $registro->foto_falla;
            /*  dd($nombreArchivo); */

            $destination = public_path('storage\\' . $registro->foto_falla);
            /* dd($destination); */

            /* imagen usuario*/
            $previousPath = $registro->foto_falla;

            /* dd($previousPath); */

            $manager = new ImageManager(new Driver());
            $name_gen =hexdec((uniqid())).'.'.$this->foto_falla->getClientOriginalExtension();
            $img = $manager->read($this->foto_falla);
            $img=$img->resize(600,600);
            $img->toJpeg(80)->save(Storage::path('public/planta/'.$name_gen));
            $save_url ='public/images/planta/'.$name_gen;

           /*  $path = $this->foto_falla->store('/', 'planta');
            $registro->update(['foto_falla' => $path]); */
            $registro->update(['foto_falla' => $name_gen]);

            Storage::disk('planta')->delete($previousPath);
        } else {
            /* codigo para la imagen cambiar */
        }

        /* este es el codigo que va en original */
        /*  if ($this->foto_falla) {
            $validateDate['foto_falla'] = $this->foto_falla->store('/', 'planta');
        } */

        $this->falla->update($validateDate);
        $this->dispatchBrowserEvent('hide-formfallaedit', ['message' => 'Falla updated successfully!']);
    }

    protected function cleanupOldUploads()
    {

        $storage = storage::disk('local');
        /*  dd($storage->allFiles(('livewire-tmp'))); */

        foreach ($storage->allFiles('livewire-tmp') as $filePathname) {
            $yesterdaysStamp = now()->subSecond(4)->timestamp;
            if ($yesterdaysStamp > $storage->lastModified($filePathname)) {
                $storage->delete($filePathname);
            }
        }
    }
    public function confirmFallaRemoval($fallaId)
    {
        /* dd($tag18Id); */
        $this->fallaIdBeingRemoved = $fallaId;
        $this->dispatchBrowserEvent('show-delete-modal-falla');
    }
    public function deleteFalla()
    {
        $falla = Falla::findOrFail($this->fallaIdBeingRemoved);

        Storage::disk('planta')->delete($falla->foto_falla);  /* Elimina solo la imagen */
        $falla->delete();
        $this->dispatchBrowserEvent('hide-delete-modal-falla', ['message' => 'La falla ha sido borrada exitosamente!']);
    }

    public function mount(Trabajo $trabajo)
    {
        /* se pasan los valores a los combos */
             /* dd($trabajo); */
            $this->trabajo = $trabajo;
            $this->statetrabajo=$trabajo->toArray();
            $this->statetrabajo['id_tag18'];
            /*   dd($this->statetrabajo['id_tag18']); */

            $tagsValores= Tag18::find($this->statetrabajo['id_tag18']);
          /* $id_centro= $tagsValores->id_cen;
           $id_planta= $tagsValores->id_planta; */
            $id_tag=$tagsValores->id;

            $this->selectedCentroListFallas = $tagsValores->id_cen;
            $this->selectedPlantaListFallas = $tagsValores->id_planta;
            $this->tag = $id_tag;    /* es el id del trag no de la falla */

        /* $this->centros = Centro::all(); */
             $this->centros = Centro::orderBy('centro_id','DESC')->get();
            $this->plantas = Planta::orderby('nombre_planta','DESC')->get();

            $this->status = Strabajo::all();
        /* $fechaactual=now()->year;
        $this->porAno=$fechaactual; */
    }



    public function render()
    {
        $fallas = Falla::where('id_tag18s','LIKE',$this->tag)->get();

        return view('livewire.admin.trabajo.list-consultas')
        ->with('fallas', $fallas);
    }
}

/*         return view('livewire.admin.trabajo.list-consultas');
    }
} */
