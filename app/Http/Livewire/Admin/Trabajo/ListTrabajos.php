<?php

namespace App\Http\Livewire\Admin\Trabajo;

use App\Models\Categoria;
use App\Models\Centro;
use App\Models\Falla;
use App\Models\Planta;
use App\Models\Seccion;
use App\Models\Stag;
use App\Models\Tag18;
use App\Models\Trabajo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ListTrabajos extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $state = [];
    public $statetrabajo =[];
    public $centros=[];
    public $modalcentros=[];
    public $modalplantas=[];
    public $fallaplantas=[];
    public $plantas=[];
    public $seccions=[];
    public $fallastatus=[];
    public $statusModals=[];

    public $categorias;
    public $status;
    public $foto;
    public $foto_trabajo;
    public $editTrabajoModal=false;
    public $tag18;
    public $planta;
    public $trabajo;
    public $id_falla;
    public $des_trabajo;
    public $id_tag18s;
    public $tagnombre;
    public $descripcionfalla;
    public $descripciontrabajo1;

    public $selectedCentro = NULL;
    public $selectedPlanta = NULL;
    public $selectedSeccion = NULL;
    public $selectedCategoria = NULL;
    public $selectedStatus = NULL;

    public $selectedStatusModal = NULL;

    protected $listeners = ['deleteConfirmed' => 'deleteTag'];

    public $trabajoIdBeingRemoved = null;

    public $byCenter = null;
    public $perPage = 5;
    public $sortBy = 'asc';
    public $search;
    public $messaje = 'Para mostrar';
    public $readyToLoad = false;
    public $porAno;


    public function mount()
    {
        $this->centros = Centro::orderBy('nombre_centro','ASC')->get();
        $this->seccions = Seccion::orderBy('descripcion_s', 'ASC')->get();
        $this->categorias = Categoria::orderBy('descripcion_c', 'ASC')->get();
        $this->status = Stag::all();
        $this->statusModals =Stag::all();
        $this->fallastatus=Stag::all();
        $this->tag18 = Tag18::all();

        $fechaactual=now()->year;
        $this->porAno=$fechaactual;


    }

    public function updatedselectedCentro($centro)
    {  $this->readyToLoad = true;

        /* dd($centro);  */
        $this->plantas = Planta::where('id_centro', $centro)
        ->orderBy('nombre_planta','ASC')->get();
        /* $this->selectedPlanta = NULL; */
        $this->planta = $this->plantas->first()->id ?? null;
    }

    public function edit(Trabajo $trabajo)
    {

             /* dd($trabajo); */

        $this->editTrabajoModal = true;
        /*  dd('hola'); */
        $this->trabajo = $trabajo;
        $this->state = $trabajo->toArray();

          /* dd($this->state); */

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

        $this->dispatchBrowserEvent('show-formtrabajoedit');
    }

    public function updatetrabajo()
    {
            /* dd($this->state);  */
            /* dd($this->selectedStatusModal); */

        $validateDate = Validator::make(
            $this->state,
            [
                'des_trabajo' => 'required',
                'id_strabajos' => 'required',

            ],
            [
                'des_trabajo.required' => 'La descripcion del trabajo es requerida.',
                'id_strabajos".required' => 'El Status es requerido.',
            ]
        )->validate();


        $validateDate['des_trabajo'] =  strtoupper($this->descripciontrabajo1);

        if ($this->selectedStatusModal == NULL)  {
            $this->selectedStatusModal= 5;
        }

        $validateDate['id_strabajos'] = $this->selectedStatusModal;
        /* dd($validateDate); */


        if ($this->foto_trabajo != null) {

            $registro = Trabajo::findOrFail($this->state['id']); /* regresa todo el registro completo */

            /* dd($registro);  */
            $filename = "";
            $nombreArchivo = $registro->foto_trabajo;
            /*  dd($nombreArchivo); */

            $destination = public_path('storage\\' . $registro->foto_trabajo);
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



        /* if ($this->foto_trabajo) {
            $validateDate['foto_trabajo'] = $this->foto_trabajo->store('/', 'planta');
        } */



        $falla1 = Falla::find($this->id_falla);
         $tagNombre = $falla1->id_tag18s;

         $tag18= Tag18::find($tagNombre);
        /*  $tag= $tagsValores->tag; */

         if ($this->selectedStatusModal == 7) {
            $validateTags['id_status'] = 1;
            $validateTags['tfalla']='FALSE';
            $validateTags['ttrabajo']='FALSE';

            $tag18->update($validateTags);
        }
        $this->trabajo->update($validateDate);
        $this->dispatchBrowserEvent('hide-formtrabajoedit', ['message' => 'El trabajo  updated successfully!']);
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
        $this->trabajoIdBeingRemoved = $trabajoId;
        $this->dispatchBrowserEvent('show-delete-modal-trabajo');
    }
    public function deleteTrabajo()
    {
        $trabajo = Trabajo::findOrFail($this->trabajoIdBeingRemoved);
        Storage::disk('planta')->delete($trabajo->foto_trabajo);  /* Elimina solo la imagen */

        $trabajo->delete();
        $this->dispatchBrowserEvent('hide-delete-modal-trabajo', ['message' => 'El trabajo ha sido borrada exitosamente!']);
    }

    public function render()
    {
          if ($this->readyToLoad  ) {
            /*  $trabajos = Trabajo::with('fallatrabajos', 'tagstrabajos','statustraba')
            ->paginate(); */

                $trabajos = Trabajo::join('fallas','fallas.id','=','trabajos.id_falla')
                /* ->select('trabajos.*','fallas.*') */
                ->join('tag18s','tag18s.id','=','fallas.id_tag18s')
                /* ->select('trabajos.*','tag18s.*','fallas.*') */
                ->when($this->selectedCentro, function ($query){
                    $query->whereRelation('fallatrabajos', 'id_cen', $this->selectedCentro)
                    ->whereYear('trabajos.created_at',now()->year($this->porAno))
                    ->select('trabajos.*');
                 })
                  ->when($this->selectedPlanta, function ($query) {
                    $query->whereRelation('fallatrabajos', 'id_planta', $this->selectedPlanta)

                    ->select('trabajos.*');
                })
                ->when($this->selectedCategoria, function ($query) {
                    $query->whereRelation('fallatrabajos', 'id_categoria',  $this->selectedCategoria)
                    ->select('trabajos.*');
                })
                ->when($this->selectedStatus, function ($query) {
                    $query->where('id_strabajos', $this->selectedStatus)
                    ->select('trabajos.*');
                })
                ->when($this->search, function($query){
                    $query->whereRelation('fallatrabajos', 'tag','like','%' .$this->search. '%')
                    ->select('trabajos.*');
                })

                   ->paginate();
             } else {
                $trabajos = [];
            }



        return view('livewire.admin.trabajo.list-trabajos')
        ->with('trabajos', $trabajos);
    }


}
