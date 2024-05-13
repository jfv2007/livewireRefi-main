<?php

namespace App\Http\Livewire\Admin\Tag18;

use App\Models\Centro;
use App\Models\Falla;
use App\Models\Planta;
use App\Models\Strabajo;
use App\Models\Tag18;
use App\Models\Trabajo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ListTrabajosTags18 extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $centros = [];
    public $statefalla = [];
    public $statelistfalla = [];


    public $tag18;
    public $plantas;
    public $centro;
    public $tag;
    public $foto_trabajo;

    public $trabajo;
    public $selectedCentroListFallas = NULL;
    public $selectedPlantaListFallas = NULL;
    public $selectedStatusModal=NULL;

    public $readyToLoad = false;

    public $tag18IdBeingRemoved = null;

    /* public $mensaje=''; */

    protected $rules = [
        'descripciontrabajo1' => [
            'required'
        ],
        'selectedStatusModal' => [
            'required'
        ],

        /* 'foto_trabajo' => [
            'required',
            'mimes:jpg,jpeg,png'
        ], */
    ];

    protected $messages = [
        'descripciontrabajo1.required' => 'La descripcion del trabajo es requerida',
        'selectedStatusModal.required' => 'El Status del trabajo es requerido',
       /* 'operacion.required' => 'El valor de operacion es requerido',
        'ubicacion.required' => 'La ubicacion es requerdida'*/
      /*   'foto_trabajo.required' => ' la imagen es requerida', */
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    public function editconsulta(Trabajo $trabajo)
    {

        /* dd($trabajo); */

        $this->consultaeditTrabajoModal = true;
        /*  dd('hola'); */
        $this->trabajo = $trabajo;
        $this->state = $trabajo->toArray();

          $this->id_falla = $this->state['id_falla'];
          $this->des_trabajo = $this->state['des_trabajo'];
          /* $this->selectedStatusModal =$this->state['id_strabajos']; */
          $this->id_tag18s =$this->id_falla;
         /*   dd($this->des_trabajo); */

         /* $falla = Falla::where('id', $this->id) */

           /* $falla1 = Falla::with('fallatrabajos')
           ->orWhereHas('fallatrabajos',function ($query){
              $query->where('id', $this->id_falla);
          })
          ->get(); */
           $falla1 = Falla::find($this->id_falla);
           $tagNombre = $falla1->id_tag18s;

           $tagsValores= Tag18::find($tagNombre);
           $tag= $tagsValores->tag;
             /* dd($tagsValores);  */

           $descripcionFalla=$falla1->descripcion_falla;

           $this->tagnombre = $tag;
           $this->descripcionfalla=$descripcionFalla;
           $this->descripciontrabajo1 = $this->des_trabajo;

          /*  dd($falla1); */

          /* $fallaTrabajo1 = Search::new()
          -> add(Falla::with('fallatrabajos'),'id')
          ->search($this->id_falla);
          dd($fallaTrabajo1); */

          /*$tags18 =$fallaTrabajo->fallatrabajos;

           dd($tags18); */

        /*   $fallaDescripcion=$falla->descripcion_falla; */

          /*  $trabajos = Falla::with(['tagfallas', 'fllastatus'])
           ->when('id', $this->id_fallas)
          ->get(); */

         /*  dd($this->fallaDescripcion); */

          $this->dispatchBrowserEvent('show-formtrabajoeditconsulta');

    }

    public function updatetrabajoconsulta()
    {
            /* dd($this->state); */

            $date = Carbon::now();
        /* $date = $date->format('Y-m-d'); */
        /* $date = $date->toTimeString(); */
        $date = $date->toDateTimeString();

       /*  $validateDate = Validator::make(
            $this->state,
            [
                'des_trabajo' => 'required',
                'id_strabajos' => 'required',
            ],
            [
                'des_trabajo.required' => 'La descripcion del trabajo es requerida.',
                'id_strabajos".required' => 'El Status es requerido.',
            ]
        )->validate(); */
        $this->validate();


        $validateDate['des_trabajo'] =  strtoupper($this->descripciontrabajo1);
        $validateDate['id_strabajos'] = $this->selectedStatusModal;
        $validateDate['updated_at'] = $date;;

        /* dd($validateDate); */

        /* if ($this->foto_trabajo) {
            $validateDate['foto_trabajo'] = $this->foto_trabajo->store('/', 'planta');
        } */

        /* Codigo para grabar la imagen nueva y borrar la vieja */
        if ($this->foto_trabajo != null) {
            /* para actualizar una imagen */
             $registro =Trabajo::findOrFail($this->state['id']); /* regresa todo el registro completo */
            /*  dd($registro);  */
            $filename = "";
            $nombreArchivo = $registro->foto_trabajo;
              /*  dd($nombreArchivo); */
            $destination=public_path('storage\\'.$registro->foto_trabajo);
             /* dd($destination); */
             /* imagen usuario*/
            $previousPath = $registro->foto_trabajo;

             /* dd($previousPath); */
             $manager = new ImageManager(new Driver());
             $name_gen =hexdec((uniqid())).'.'.$this->foto_trabajo->getClientOriginalExtension();
             $img = $manager->read($this->foto_trabajo);
             $img=$img->resize(600,600);
             $img->toJpeg(80)->save(Storage::path('public/planta/'.$name_gen));
             $save_url ='public/images/planta/'.$name_gen;

            /* $path = $this->foto_trabajo->store('/', 'planta');
            $registro->update(['foto_trabajo' => $path]); */
            $registro->update(['foto_trabajo' => $name_gen]);

             Storage::disk('planta')->delete($previousPath);
        } else {
                /* codigo para la imagen cambiar */
        }

        $falla1 = Falla::find($this->id_falla);
         $tagNombre = $falla1->id_tag18s;
         $tag18= Tag18::find($tagNombre);
        /*  $tag= $tagsValores->tag; */

         if ($this->selectedStatusModal == 7) {
            $validateTags['id_status'] = 1;
            $tag18->update($validateTags);
        }

        $this->trabajo->update($validateDate);
        $this->dispatchBrowserEvent('hide-formtrabajoeditconsulta', ['message' => 'El trabajo  updated successfully!']);
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


    public function confirmTrabajoRemoval($trabajoId)
    {
        /* dd($tag18Id); */
        $this->tag18IdBeingRemoved = $trabajoId;
        $this->dispatchBrowserEvent('show-delete-modal-trabajo');
    }

    public function deleteTrabajo()
    {
        $trabajo = Trabajo::findOrFail($this->tag18IdBeingRemoved);
        /* dd($tag18); */
        /* dd($tag18->foto); */

        /* **************Pone el tag disponible********** */
        $falla1 = Falla::find($this->id_falla);
        $tagNombre = $falla1->id_tag18s;

        $tag18= Tag18::find($tagNombre);
       /*  $tag= $tagsValores->tag; */


           $validateTags['id_status'] = 1;
           $validateTags['tfalla']='FALSE';
           $validateTags['ttrabajo']='FALSE';
           $tag18->update($validateTags);


        Storage::disk('planta')->delete($trabajo->foto_trabajo);  /* Elimina solo la imagen */
        $trabajo->delete();

        $this->dispatchBrowserEvent('hide-delete-modal-trabajo', ['message' => 'Tag deleted successfully!']);
    }

    public function mount(Tag18 $tag18)
    {
        /* se pasan los valores a los combos */

        $this->tag18 = $tag18;
        $this->statefalla = $tag18->toArray();
          /*  dd($tag18); */

        $this->selectedCentroListFallas = $this->statefalla['id_cen'];
        $this->selectedPlantaListFallas = $this->statefalla['id_planta'];
        $this->tag = $this->statefalla['id'];  /* es el id del trag no de la falla */

        /* $this->centros = Centro::all(); */
        $this->centros = Centro::orderBy('centro_id', 'DESC')->get();
        $this->plantas = Planta::orderby('nombre_planta', 'DESC')->get();

        /* $this->status = Strabajo::all(); */

        /*  $fallas = Falla::with(['tagfallas', 'fllastatus'])
        ->where('id_tag18s','=', 1557); */

        /* $tagBusqueda= Tag18:: where('id','1557')->get(); */


        /* dd($fallas); */
        /* dd($tagBusqueda); */
    }



    public function render()
    {

        /* busqueda anterior  */
        /* $trabajos = Trabajo::join('fallas','fallas.id_tag18s','=','trabajos.id_tag18')
                    ->where('id_tag18','=',  $this->tag)
                    ->get();
        */

        $trabajos = Trabajo::join('fallas', 'fallas.id', '=', 'trabajos.id_falla')
            /* ->select('trabajos.*','fallas.*') */
            ->join('tag18s', 'tag18s.id', '=', 'fallas.id_tag18s')
            /* ->select('trabajos.*','tag18s.*','fallas.*') */
            ->whereRelation('fallatrabajos', 'id_cen', $this->selectedCentroListFallas)
            ->select('trabajos.*')

            ->whereRelation('fallatrabajos', 'id_planta', $this->selectedPlantaListFallas)
            ->select('trabajos.*')

            ->where('trabajos.id_tag18', '=', $this->tag)

            ->get();
        /* dd($trabajos); */


        return view('livewire.admin.tag18.list-trabajos-tags18')
            ->with('trabajos', $trabajos);
    }
}
