<?php

namespace App\Http\Livewire\Admin\Plantas;

use App\Models\Centro;
use App\Models\Planta;
use App\Models\Tag18;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ListPlantas extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $centros=[];
    public $plantas=[];

    public $modalcentros=[];
    public $modalplantas=[];
    public $state=[];

    public $planta;
    public $showEditModal = false;

    public $selectedCentro = NULL;
    public $selectedCentroModal = NULL;

    public $readyToLoad = false;

    protected $listeners = ['deleteConfirmed' => 'deletePlanta'];
    public $plantaIdBeingRemoved = null;

    public $perPage = 10;


    public function mount()
    {
        /* $this->centros = Centro::all(); */
        $this->centros = Centro::orderBy('centro_id','DESC')->get();
         $this->modalcentros = Centro::orderBy('centro_id','DESC')->get();

    }
    public function updatedselectedCentro($centro)
    {  $this->readyToLoad = true;

        /* dd($centro);  */
        $this->plantas = Planta::where('id_centro', $centro)
        ->orderBy('nombre_planta','ASC')->get();
        /* $this->selectedPlanta = NULL; */
         $this->planta = $this->plantas->first()->id ?? null;

    }

 /*  */


    public function addNewPlanta()
    {
         /* dd('here'); */
         $this->state = [];
         /* $this->foto=''; */

         $this->dispatchBrowserEvent('show-formplanta');
    }



    public function createPlanta()
    {
         /* dd($this->selectedCentroModal); */
          /* dd($this->state);  */

        /*   $pid=$this->state['planta_id'];
          $np=$this->state['nombre_planta']; */

          /* dd($ids); */


         /* dd($this->state['nombre_planta']); */

        $validateDate= Validator::make(
            $this->state,
            [
                'planta_id'=>'required',
                'nombre_planta'=>'required',
             ],
             [
                'planta_id.required' =>' El id planta es requerido.',
                'nombre_planta.required' => 'Nombre de la planta es requerido.',
             ]
             )->validate();

             $validateDate['planta_id'] = strtoupper($this->state['planta_id']);/*convierte a mayuscula el registro tag */
             $validateDate['nombre_planta'] = strtoupper($this->state['nombre_planta']);
             $validateDate['id_centro'] = $this->selectedCentroModal;;


             Planta::create($validateDate);
             $this->dispatchBrowserEvent('hide-formplanta',['message' => 'Se agrego planta satisfactoriamente!'] );

             return redirect()->back();
    }

    public function edit(Planta $planta)
    {
         /* dd($tag18); */
        $this->showEditModal=true;

        $this->planta=$planta;
        $this->state=$planta->toArray();
        $this->selectedCentroModal = $this->state['id_centro'];


        $this->modalplantas =Planta::all();
         /* $this->foto = $this->state['foto']; */
        $this->dispatchBrowserEvent('show-formplanta');
    }



    public function updatePlanta()
    {
         /* dd('here');  */
        $validateDate= Validator::make(
            $this->state,
            [
                'planta_id'=>'required',
                'nombre_planta'=>'required',
             ],
             [
                'planta_id.required' =>' Id de planta es requerido.',
                'nombre_planta.required' =>' Nombre de la planta es requerido.',

             ]
             )->validate();

             $validateDate['id_centro'] = $this->selectedCentroModal;


             $this->planta->update($validateDate);
             $this->dispatchBrowserEvent('hide-formplanta',['message' => 'Planta updated successfully!']);

    }

    public function confirmPlantaRemoval($plantaId)
    {
        /* dd($tag18Id); */
        $this->plantaIdBeingRemoved = $plantaId;
        $this->dispatchBrowserEvent('show-delete-modal');
    }

    public function deletePlanta()
    {
        $planta = Planta::findOrFail($this->plantaIdBeingRemoved);
        $planta->delete();
        $this->dispatchBrowserEvent('hide-delete-modal', ['message' => 'Planta deleted successfully!']);
    }


    public function render()
    {
        /* $tag18s =Tag18::with('tag18Centro')->latest('id')
         ->paginate();*/

         if ($this->readyToLoad  ) {

            /* $plantas = Planta::where('id_centro', 5)
                 ->orderBy('nombre_planta','ASC')->get(); */

             $plantas = Planta::with(['centros'])
            ->when($this->selectedCentro, function ($query) {
                $query->where('id_centro', $this->selectedCentro);
            })
            ->paginate($this->perPage);

            } else {
            $plantas = [];
        }
         return view('livewire.admin.plantas.list-plantas')
         ->with('plantas',$plantas);
    }
}
