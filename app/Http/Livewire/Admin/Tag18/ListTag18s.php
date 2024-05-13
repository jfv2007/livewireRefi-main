<?php

namespace App\Http\Livewire\Admin\Tag18;

use App\Http\Livewire\Admin\Falla\ListFallas;
use App\Models\Categoria;
use App\Models\Centro;
use App\Models\Falla;
use App\Models\Planta;
use App\Models\Seccion;
use App\Models\Stag;
use App\Models\Strabajo;
use App\Models\Tag18;
use App\Models\Trabajo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Intervention\Image\ImageManager;
 use Intervention\Image\Drivers\Gd\Driver;
/* use Intervention\Image\Drivers\Imagick\Driver; */



class ListTag18s extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    /* public $tag;
    public $descripcion;
    public $operacion;
    public $ubicacion; */

    public $state = [];
    public $statefalla=[];
    public $statelistfalla=[];
    public $tag18;
    public $showEditModal = false;
    public $showHistorialModal=false;
    public $users;
    public $fallas;
    /* public $showFallaModal =false; */

    public $centros=[];
    public $modalcentros=[];
    public $modalplantas=[];
    public $fallaplantas=[];
    public $plantas=[];
    public $selectedRows = [];
    public $selectPageRows = false;

    public $categorias;
    public $status;
    public $foto;
    public $foto_falla;

    public $selectedCentro = NULL;
    public $selectedPlanta = NULL;
    public $selectedSeccion = NULL;
    public $selectedCategoria = NULL;
    public $selectedStatus = NULL;

    public $selectedCentroModal = NULL;
    public $selectedPlantaModal = NULL;
    public $selectedSeccionModal = NULL;
    public $selectedCategoriaModal = NULL;
    public $selectedStatusModal = NULL;

    public $selectedCentroFalla = NULL;
    public $selectedPlantaFalla = NULL;
    public $selectedTurnoFalla=NULL;
    public $selectedStatusFalla=NULL;
   /*  public $showFallaModal= false; */

    protected $listeners = ['deleteConfirmed' => 'deleteTag'];

    public $tag18IdBeingRemoved = null;

    public $byCenter = null;
    public $perPage = 5;
    public $sortBy = 'asc';
    public $search;
    /* public $messaje = 'Para mostrar'; */
    public $readyToLoad = false;

    public $tag;
    public $descripcion;
    public $operacion;
    public $ubicacion;
    public $file;

    protected $rules = [
        'tag' => [
            'required'
        ],
        'descripcion' => [
            'required'
        ],
        'operacion' => [
            'required'
        ],
        'ubicacion' => [
            'required'
        ],
        'selectedCentroModal' => [
            'required'
        ],
        'selectedPlantaModal' => [
            'required'
        ],
        'selectedSeccionModal' => [
            'required'
        ],
        'selectedCategoriaModal' => [
            'required'
        ],
           'foto' => [
            'required',
            'mimes:jpg,jpeg,png'
        ],
    ];
    /* 'required|image|mimes:jpeg,bmp,png' */
    protected $messages = [
        'tag.required' => 'El tag es Requerido',
        'descripcion.required' => 'El producto es obligatorio',
        'operacion.required' => 'El valor de operacion es requerido',
        'ubicacion.required' => 'La ubicacion es requerdida',
        'foto.required' => ' La imagen es requerida'
    ];

    public function upload()
    {

        $this->validate([
            'foto' => 'required|file',
        ]);
       /*  dd('hello');
        dd($this->foto); */

    }

     /* public function updatedfoto()
    {
        $this->validate([
            'foto' => 'image|max:1024',
        ]);
    }  */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

   /*  public function updatedSelectPageRows($value)
	{
		if ($value) {
			$this->selectedRows = $this->tag18s->pluck('id')->map(function ($id) {
				return (string) $id;
			});
		} else {
			$this->reset(['selectedRows', 'selectPageRows']);
		}
	} */



    public function mount()
    {
        /* $this->centros = Centro::all(); */
        $this->centros = Centro::orderBy('centro_id','DESC')->get();
        $this->modalcentros = Centro::orderBy('centro_id','DESC')->get();
        $this->seccions = Seccion::all();
        $this->modalseccions = Seccion::all();
        $this->categorias = Categoria::all();
        $this->modalcategorias = Categoria::all();
        /* $this->status = Strabajo::all(); */
        $this->status = Stag::all();

        $this->modalstatus = Stag::all();
        $this->fallastatus=Stag::all();
        /* $this->fallas= Falla::all(); */
    }

    public function updatedselectedCentro($centro)
    {  $this->readyToLoad = true;

        /* dd($centro);  */
        $this->plantas = Planta::where('id_centro', $centro)
        ->orderBy('nombre_planta','ASC')->get();
        /* $this->selectedPlanta = NULL; */
        $this->planta = $this->plantas->first()->id ?? null;

    }

    public function updatedselectedCentroModal($centrovalue)
    {
        $this->readyToLoad = true;

        /* dd($centro);  */
        $this->modalplantas= Planta::where('id_centro', $centrovalue)
        ->orderBy('nombre_planta','ASC')->get();
        /* $this->selectedPlanta = NULL; */
       /*  $this->modalplanta = $this->modalplantas->first()->id ?? null; */
    }
    public function updatedselectedPlantaFalla($centrovalue)
    {   $this->readyToLoad = true;

        /* dd($centro);  */
        $this->fallaplantas= Planta::where('id_centro', $centrovalue)
        ->orderBy('nombre_planta','ASC')->get();
        /* $this->selectedPlanta = NULL; */
       /*  $this->modalplanta = $this->modalplantas->first()->id ?? null; */
    }

    public function addNewTag()
    {
         /* dd('here'); */
         $this->state = [];
         $this->foto='';


         $this->dispatchBrowserEvent('show-formtag');
    }

    public function createTag()
    {
        /* $this->foto=''; */
          /* dd('here'); */
        /* dd($this->state); */
       /*  dd($this->selectedPlantaModal); */
          /*dd($this->selectedPlantaModal); */

        /* $valorPlanta =$this->selectedPlantaModal;
        $valorPlanta->validate([
            'selectedPlantaModal' =>'required'
        ],

        [
            'required' =>'el atributo es requerido',
        ]); */

        /* $validateDate= Validator::make(
            $this->state,
            [
                'tag'=>'required',
                'descripcion'=>'required',
                'operacion'=>'required',
                'ubicacion'=>'required',
             ],
             [
                'tag.required' =>' El Tag es requerido.',
                'descripcion.required' =>' La Descripcion es requerido.',
                'operacion.required' =>' La operacion es requerida.',
                'ubicacion.required' =>' La Ubicacion es requerida.',
             ]
             )->validate(); */

        /* $tags=strtoupper($this->tag); */


        $this->validate();
       /*  dd($this->foto->store('/', 'planta')); sale la direccion de la imagen*/
        /*  $validateDate2['id_cen'] = $this->selectedCentroModal; */
        /* $validateDate['tag'] = strtoupper($this->state['tag']);/*convierte a mayuscula el registro tag
             $validateDate['descripcion'] = strtoupper($this->state['descripcion']);
             $validateDate['operacion'] = strtoupper($this->state['operacion']);
             $validateDate['ubicacion'] = strtoupper($this->state['ubicacion']);
             $validateDate['id_cen'] = $this->selectedCentroModal;
             $validateDate['id_planta']=$this->selectedPlantaModal;
             $validateDate['id_seccion']=$this->selectedSeccionModal;
             $validateDate['id_categoria']=$this->selectedCategoriaModal; */
        /* $validateDate['id_status']=$this->selectedStatusModal; */
        /* $validateDate['id_status']=1; */
        /* if ($this->foto) {
             $validateDate['foto'] = $this->foto->store('/', 'planta');  */
        /*   $validateDate['avatar'] = $this->photo->store('/', 'avatars'); */
        /* $fotohash= $this->foto->store('/', 'planta'); */

        $manager = new ImageManager(new Driver());
        $name_gen =hexdec((uniqid())).'.'.$this->foto->getClientOriginalExtension();
        $img = $manager->read($this->foto);
        $img=$img->resize(600,600);
        $img->toJpeg(80)->save(Storage::storage_path('public/planta/'.$name_gen));
       /*  $img->toJpeg(80)->save(Storage::path('public/planta/'.$name_gen)); */
        $save_url ='public/images/planta/'.$name_gen;
        /* $file2= Storage::put('public/imagen', $request->file('foto_falla')); */
        /* $file->storeAs('/public/imagen', $fileName); */
        /* return $file2; */
        /* $img->toJpeg(80)->save(base_path('public/planta'.$name_gen));
        Storage::disk('storage-dir')->path('sub-dir/file.txt')
        Storage::path('Test/SubDir/Test.xlsx')*/
        /*
        {{ asset('planta/'.$name_gen) }}
        Storage::disk('planta')*//*
        $img->toJpeg(80)->save('planta/'.$name_gen); */
       /*  $img->toJpeg(80)->save(storage_path('../planta/'.$name_gen)); */



        Tag18::create([
            'tag' => strtoupper($this->tag),
            'descripcion' => strtoupper($this->descripcion),
            'operacion' => strtoupper($this->operacion),
            'ubicacion' => strtoupper($this->ubicacion),
            'id_cen' => $this->selectedCentroModal,
            'id_planta' => $this->selectedPlantaModal,
            'id_seccion' => $this->selectedSeccionModal,
            'id_categoria' => $this->selectedCategoriaModal,
            'id_status' => 1,
            /* 'foto' =>  $this->foto->store('/', 'planta'), */
             'foto' =>  $name_gen,
            'tfalla' =>'FALSE',
            'ttrabajo'=> 'FALSE',

        ]);


        $this->dispatchBrowserEvent('hide-formtag', ['message' => 'Tag Add created successfully!']);

        return redirect()->back();

        $this->reset();

    }

    public function createFalla()
    {
       /* $users = User::pluck('id','id');  saca todos los id */
        $user_id=auth()->user()->id;
         $date = Carbon::now();
        /* $date = $date->format('Y-m-d'); */
        /* $date = $date->toTimeString(); */
         $date =$date->toDateTimeString();
        /*$ids=$this->statefalla['id'];
         dd($ids); */
         /* dd($this->statefalla); */
        /* dd($user_id); */
        /* dd($date); */

         $validateDate= Validator::make(
            $this->statefalla,
            [
                'tag' => 'required',
                'descripcionfalla'=>'required',
             ],
             [
                'tag.required' =>' El Tag es requerido.',
                'descripcionfalla.required' =>' La Descripcion es requerido.',
             ]
             )->validate();


             $validateDate['id_tag18s']=$this->statefalla['id'];
             $validateDate['id_usuario'] = auth()->user()->id;
             /* $validateDate['id_sfallas']=$this->selectedStatusFalla; */
             $validateDate['id_sfallas']=3;
             $validateDate['descripcion_falla']= strtoupper($this->statefalla['descripcionfalla']);
             $validateDate['turno'] = 1;
             $validateDate['created_at']=$date;
             $validateDate['updated_at']=$date;


             /* dd($validateDate); */
              if ($this->foto) {
                $manager = new ImageManager(new Driver());
                $name_gen =hexdec((uniqid())).'.'.$this->foto->getClientOriginalExtension();
                $img = $manager->read($this->foto);
                $img=$img->resize(600,600);
                $img->toJpeg(80)->save(Storage::path('public/planta/'.$name_gen));

                $validateDate['foto_falla'] = $name_gen;
             /* $validateDate['foto_falla'] = $this->foto->store('/', 'planta') */
             }

            /*  $tag18= Tag18::find($this->statefalla['id']); */
            /*busca el tag*/
             /* dd($tag18); */
             /*  $tag= $tagsValores->tag; */

              Falla::create($validateDate);

             /* para acuatlizar el statutus del tag */
            /* $validateTags['id_status']=$this->selectedStatusFalla; */
            $validateTags['id_status'] = 2;
            $validateTags['tfalla'] ='TRUE';
            $this->tag18->update($validateTags);

            $this->dispatchBrowserEvent('hide-formfalla',['message' => 'La falla del Tag  creado!'] );

             return redirect()->back();
    }

    public function confirmTagRemoval($tag18Id)
    {
        /* dd($tag18Id); */
        $this->tag18IdBeingRemoved = $tag18Id;
        $this->dispatchBrowserEvent('show-delete-modal');
    }
    public function deleteTag()
    {
        /* $tag18 = Tag18::findOrFail($this->tag18IdBeingRemoved);
        $tag18->delete(); */
        $tag18 = Tag18::findOrFail($this->tag18IdBeingRemoved);
        Storage::disk('planta')->delete($tag18->foto);  /* Elimina solo la imagen */
        $tag18->delete();
        $this->dispatchBrowserEvent('hide-delete-modal', ['message' => 'Tag deleted successfully!']);
    }

    public function edit(Tag18 $tag18)
    {
         /* dd($tag18); */
        $this->showEditModal=true;
        $this->tag18=$tag18;
        $this->state=$tag18->toArray();
        $this->id = $tag18->id;
        /* dd($this->state);  */
        $this->tag=$this->state['tag'];
        $this->descripcion = $tag18->descripcion;
        $this->operacion = $tag18->operacion;
        $this->ubicacion = $tag18->ubicacion;
        $this->selectedCentroModal = $this->state['id_cen'];
        $this->selectedPlantaModal= $this->state['id_planta'];
        $this->selectedSeccionModal = $this->state['id_seccion'];
        $this->selectedCategoriaModal=$this->state['id_categoria'];
        $this->selectedStatusModal =$this->state['id_status'];
        /* $this->foto=$this->state['foto_url']; */
        $this->modalplantas =Planta::all();
         /* $this->foto = $this->state['foto']; */
        $this->dispatchBrowserEvent('show-formtag');
    }


    public function llamarHistorial()
    {
          /* dd('here'); */

         $this->fallas = Falla:: where('id_tag18s', 1157)
        ->get();
    }
    public function addfalla(Tag18 $tag18)
    {
         /*   dd($tag18); */
           $this->showFallaModal= true;

        $this->tag18=$tag18;
        $this->statefalla=$tag18->toArray();
        $this->selectedCentroFalla = $this->statefalla['id_cen'];
        $this->selectedPlantaFalla= $this->statefalla['id_planta'];

        $this->fallaplantas =Planta::all();

          $this->dispatchBrowserEvent('show-formfalla');
    }

    public function updateTag()
    {
         /* dd('here');  */
        $validateDate= Validator::make(
            $this->state,
            [
                'tag'=>'required',
                'descripcion'=>'required',
                'operacion'=>'required',
                'ubicacion'=>'required',
             ],
             [
                'tag.required' =>' El Tag es requerido.',
                'descripcion.required' =>' La Descripcion es requerido.',
                'operacion.required' =>' La operacion es requerida.',
                'ubicacion.required' =>' La Ubicacion es requerida.',
             ]
             )->validate();
             $validateDate['tag'] = strtoupper($this->tag);
             $validateDate['descripcion'] = strtoupper($this->descripcion);
             $validateDate['operacion'] = strtoupper($this->operacion);
             $validateDate['ubicacion'] = strtoupper($this->ubicacion);

             $validateDate['id_cen'] = $this->selectedCentroModal;
             $validateDate['id_planta']=$this->selectedPlantaModal;
             $validateDate['id_seccion']=$this->selectedSeccionModal;
             $validateDate['id_categoria']=$this->selectedCategoriaModal;
             $validateDate['id_status']=$this->selectedStatusModal;

             if ($this->selectedStatusModal = 1) {
                $validateDate['tfalla'] = 'FALSE';
            }
            if ($this->foto != null) {
                $registro = Tag18::findOrFail($this->state['id']); /* regresa todo el registro completo */
            $filename = "";
            $nombreArchivo = $registro->foto;
            $destination = public_path('storage\\' . $registro->foto);
            $previousPath = $registro->foto;  /* saca la dirreccion de la foto viej */

            $manager = new ImageManager(new Driver());
            $name_gen =hexdec((uniqid())).'.'.$this->foto->getClientOriginalExtension();
            $img = $manager->read($this->foto);
            $img=$img->resize(600,600);
            $img->toJpeg(80)->save(Storage::path('public/planta/'.$name_gen));
            $save_url ='public/images/planta/'.$name_gen;

           /*  $path = $this->foto->store('/', 'planta');
            $registro->update(['foto' => $path]); */
            $registro->update(['foto' => $name_gen]);

            Storage::disk('planta')->delete($previousPath);
            } else {
                /* codigo para la imagen cambiar */
            }

              if ($this->foto) {
                $manager = new ImageManager(new Driver());
                $name_gen =hexdec((uniqid())).'.'.$this->foto->getClientOriginalExtension();
                $img = $manager->read($this->foto);
                $img=$img->resize(600,600);
                $img->toJpeg(80)->save(Storage::path('public/planta/'.$name_gen));
                 $save_url ='public/images/planta/'.$name_gen;

                /* $validateDate['foto'] = $this->foto->store('/', 'planta'); */
                $validateDate['foto'] = $name_gen;

             }

             $this->tag18->update($validateDate);
             $this->dispatchBrowserEvent('hide-formtag',['message' => 'Tag updated successfully!']);

    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        /* $tag18s =Tag18::with('tag18Centro')->latest('id')
         ->paginate();*/

            if ($this->readyToLoad  ) {

            $tag18s = Tag18::with(['tag18Centro', 'tag18Plantas'])
            ->when($this->selectedCentro, function ($query) {
                $query->where('id_cen', $this->selectedCentro);
            })
            ->when($this->selectedPlanta, function ($query) {
                $query->where('id_planta', $this->selectedPlanta);
            })
            ->when($this->selectedCategoria, function ($query) {
                $query->where('id_categoria', $this->selectedCategoria);
            })
            ->when($this->selectedStatus, function ($query) {
                $query->where('id_status', $this->selectedStatus);
            })
             ->when($this->search, function($query){
                $query->where('tag','like','%' .$this->search. '%');
            })

            /* _____->search(trim($this->search)) */

             ->paginate($this->perPage);
             /* ____dd($tag18s); */

            /*____$tagsCount = Tag18::with(['tag18Centro', 'tag18Plantas'])
            ->when($this->selectedCentro, function ($query) {
            $query->where('id_cen', $this->selectedCentro)
            ->first()
            ->count();
            }); */
            } else {
            $tag18s = [];
        }
         return view('livewire.admin.tag18.list-tag18s')
         ->with('tag18s',$tag18s);

    }


    public function limpiar()
    {
        /* dd('hola'); */

        $this->tag18s = [];
        $this->selectedCentro = null;
        $this->selectedPlanta = value(0);
        $this->selectedCategoria = value(0);
        $this->selectedStatus = value(0);
        /* dd($this->tag18s); */
        /* return view('livewire.admin.tag18.list-tag18s', compact('tag18s')); */
        /* $this->selectedCentro = NULL; */
    }
}
