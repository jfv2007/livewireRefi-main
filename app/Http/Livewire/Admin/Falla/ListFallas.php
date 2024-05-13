<?php

namespace App\Http\Livewire\Admin\Falla;

use App\Models\Categoria;
use App\Models\Centro;
use App\Models\Falla;
use App\Models\Planta;
use App\Models\Seccion;
use App\Models\Stag;
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

class ListFallas extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $state = [];
    public $centros = [];
    public $plantas = [];
    public $seccions = [];
    public $statetrabajo = [];
    public $fallastatus = [];

    public $categorias;
    public $status;
    public $foto_falla;
    public $foto_trabajo;
    public $editFallaModal = false;
    public $descripciontrabajo;
    public $falla;
    public $tag18;
    public $trabajo_id_tag18s;
    public $tagnombre;
    public $descripcion;
    public $planta;
    public $id_tag18s;
    public $descripcionfalla;
    public $selectedStatusModal;


    public $selectedCentro = NULL;
    public $selectedPlanta = NULL;
    public $selectedSeccion = NULL;
    public $selectedCategoria = NULL;
    public $selectedStatus = NULL;
    public $selectedStatusModalTrabajoAgregar = NULL;

    public $mensaje;
    public $error1 = false;

    public $fallaIdBeingRemoved = null;
    public $showAddTrabajoModal = false;


    public $byCenter = null;
    public $perPage = 5;
    public $sortBy = 'asc';
    public $search;
    public $porAno;

    public $readyToLoad = false;

    protected $rules = [
        'descripciontrabajo' => [
            'required'
        ],
        'selectedStatusModalTrabajoAgregar' => [
            'required'
        ],
         'foto_trabajo' => [
            'required',
        ],
    ];

    protected $messages = [
        'descripciontrabajo.required' => 'La descripcion de la falla es requerida',
        'selectedStatusModalTrabajoAgregar.required' => 'El Status de la falla es requerido',
        /* 'operacion.required' => 'El valor de operacion es requerido',
        'ubicacion.required' => 'La ubicacion es requerdida'*/
        'foto_falla.required' => ' la imagen es requerida'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount(Tag18 $tag18)
    {
        $this->tag18 = $tag18;
        $this->statefalla=$tag18->toArray();

        /* dd($tag18); */

        /* $this->centros = Centro::all(); */
        $this->centros = Centro::orderBy('nombre_centro', 'ASC')->get();
        $this->seccions = Seccion::orderBy('descripcion_s', 'ASC')->get();
        $this->categorias = Categoria::orderBy('descripcion_c', 'ASC')->get();
        $this->status = Strabajo::all();
        $this->fallastatus = Stag::all();
       /*  $this->tag18=Tag18::all(); */


        $fechaactual = now()->year;
        $this->porAno = $fechaactual;
    }
    public function updatedselectedCentro($centro)
    {
        $this->readyToLoad = true;

        /* dd($centro);  */
        $this->plantas = Planta::where('id_centro', $centro)
            ->orderBy('nombre_planta', 'ASC')->get();
        /* $this->selectedPlanta = NULL; */
        $this->planta = $this->plantas->first()->id ?? null;
    }

    public function edit(Falla $falla)
    {
          /* dd($falla);  */
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

            /* $path = $this->foto_falla->store('/', 'planta');
            /* dd($path);*/
            $manager = new ImageManager(new Driver());
            $name_gen =hexdec((uniqid())).'.'.$this->foto_falla->getClientOriginalExtension();
            $img = $manager->read($this->foto_falla);
            $img=$img->resize(600,600);
            $img->toJpeg(80)->save(Storage::path('public/planta/'.$name_gen));
            $save_url ='public/images/planta/'.$name_gen;

           /* $registro->update(['foto_falla' => $path]); */
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

    public function addtrabajo(Falla $falla)
    {   /* Muestra el modal con los datos */
         /* dd($falla); */   /* muestra los valore de la falla */

        $this->showAddTrabajoModal = true;

        $this->falla = $falla;
        $this->statetrabajo = $falla->toArray();
          /* dd($this->statetrabajo);   */


        $this->trabajo_id_tag18s = $this->statetrabajo['id_tag18s'];
        /* $this->trabajo_id_tag18s = $this->statetrabajo['id_tag18s']; */

        $tag18 = Tag18::find($this->trabajo_id_tag18s);
        $this->tag18 = $tag18;
          /* dd($tag18);  */
        /*   return $tag18; */
        $tagNombre = $tag18->tag;
        $tagDescripcion = $tag18->descripcion;

        $this->tagnombre = $tagNombre;
        $this->descripcion = $tagDescripcion;

        $this->dispatchBrowserEvent('show-formtrabajoAdd');
    }

    public function additemtrabajo()
    {

        /* dd($this->statetrabajo);  */
        /* dd($this->selectedStatusModalTrabajo); */
        /* dd($this->descripciontrabajo); */
        /* dd($this->trabajo_id_tag18s);  */
        $tag18 = Tag18::find($this->trabajo_id_tag18s);
        $this->tag18 = $tag18;

        $user_id = auth()->user()->id;
        $date = Carbon::now();
        /* $date = $date->format('Y-m-d'); */
        /* $date = $date->toTimeString(); */
        $date = $date->toDateTimeString();

       /*  $validateDate = Validator::make(
            $this->statetrabajo,
            [
                'id' => 'required',
            ],
            [
                'id.required' => ' El Tag es requerido.',
            ]
        )->validate(); */

        $this->validate();

        $validateDate['id_falla'] = $this->statetrabajo['id'];
        /* $validateDate['id_user'] = auth()->user()->id; */
        $validateDate['id_user'] = $this->statetrabajo['id_usuario'];
        if ($this->selectedStatusModalTrabajoAgregar == NULL) {
            $this->selectedStatusModalTrabajoAgregar = 5;
        }
        $validateDate['id_strabajos'] = $this->selectedStatusModalTrabajoAgregar;
        /*    $validateDate['id_strabajos'] = 4; */
        $validateDate['des_trabajo'] =  strtoupper($this->descripciontrabajo);
        $validateDate['created_at'] = $date;
        $validateDate['updated_at'] = $date;
        $validateDate['id_tag18'] = $this->trabajo_id_tag18s;

        /* dd($this->validateDate); */

        if ($this->foto_trabajo) {
            $manager = new ImageManager(new Driver());
            $name_gen =hexdec((uniqid())).'.'.$this->foto_trabajo->getClientOriginalExtension();
            $img = $manager->read($this->foto_trabajo);
            $img=$img->resize(600,600);
            $img->toJpeg(80)->save(Storage::path('public/planta/'.$name_gen));
            $save_url ='public/images/planta/'.$name_gen;

            $validateDate['foto_trabajo'] = $name_gen;
            /* $validateDate['foto_trabajo'] = $this->foto_trabajo->store('/', 'planta'); */
            /*   $validateDate['avatar'] = $this->photo->store('/', 'avatars'); */
        }

        Trabajo::create($validateDate);

        $validateFallas['id_sfallas'] = 4;
        $this->falla->update($validateFallas);

        $validateTag18['ttrabajo'] = 'TRUE';
        $this->tag18->update($validateTag18);

        $this->dispatchBrowserEvent('hide-formtrabajoAdd', ['message' => 'agregado trabajo satisfactorio!']);
    }

    public function render()
    {
        /* dd($fallas);
         dd($this->porAno); */
        /* aqui muestra todas las fallas*/


        if ($this->readyToLoad) {
            /* $tag18s = Tag18::with(['tag18Centro', 'tag18Plantas'])
                ->when($this->selectedCentro, function ($query) {
                    $query->where('id_cen', $this->selectedCentro);
                })
                ->when($this->selectedPlanta, function ($query) {
                    $query->where('id_planta', $this->selectedPlanta);
                }) */

            $fallas = Falla::with(['tagfallas', 'fllastatus'])
                ->when($this->selectedCentro, function ($query) {
                    $query->whereRelation('tagfallas', 'id_cen', $this->selectedCentro)
                        ->whereYear('created_at', now()->year($this->porAno));

                    /* $query->WhereHas('tagfallas', function ($query){
                        $query->where('id_cen', $this->selectedCentro);
                    });*/
                })

                ->when($this->selectedPlanta, function ($query) {
                    $query->WhereHas('tagfallas', function ($query) {
                        $query->where('id_planta', $this->selectedPlanta);
                    });
                })

                ->when($this->selectedCategoria, function ($query) {
                    $query->WhereHas('tagfallas', function ($query) {
                        $query->where('id_categoria',  $this->selectedCategoria);
                    });
                })

                ->when($this->selectedStatus, function ($query) {
                    $query->where('id_sfallas', $this->selectedStatus);
                })

                ->when($this->search, function ($query) {
                    $query->whereRelation('tagfallas', 'tag', 'like', '%' . $this->search . '%');
                })

                ->paginate($this->perPage);

            /*  ->toSql(); */


            /* ->paginate(); */

            /* dd($fallas); */
        } else {
            $fallas = [];
        }


        /*  dd($fallas); */
        return view('livewire.admin.falla.list-fallas')
            ->with('fallas', $fallas);
    }
}
