<?php

namespace App\Http\Livewire\Admin\Seccions;

use App\Models\Seccion;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;

class ListSeccions extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $state=[];

     public $seccion;
    public $showEditModal = false;

    protected $listeners = ['deleteConfirmed' => 'deleteSeccion'];
    public $seccionIdBeingRemoved = null;
    public $perPage = 10;


    public function addNewSeccion()
    {
         /* dd('here'); */
         $this->state = [];
         $this->dispatchBrowserEvent('show-formseccion');
    }

    public function createSeccion()
    {
         /* dd($this->selectedCentroModal); */
          /* dd($this->state);  */

        $validateDate= Validator::make(
            $this->state,
            [
                'descripcion_s'=>'required',
            ],
            [
                'descripcion_s.required' =>' La descripcion es requerido.',
            ]
             )->validate();

             $validateDate['descripcion_s'] = strtoupper($this->state['descripcion_s']);/*convierte a mayuscula el registro tag */

             Seccion::create($validateDate);
             $this->dispatchBrowserEvent('hide-formseccion',['message' => 'Se agrego planta satisfactoriamente!'] );

             return redirect()->back();
    }

    public function edit(Seccion $seccion)
    {
         /* dd($tag18); */
        $this->showEditModal=true;

        $this->seccion=$seccion;
        $this->state=$seccion->toArray();

        /* $this->modalplantas =Planta::all(); */

        $this->dispatchBrowserEvent('show-formseccion');
    }

    public function updateSeccion()
    {  /* dd('here');  */
        $validateDate= Validator::make(
            $this->state,
            [
                'descripcion_s'=>'required',
             ],
             [
                'descripcion_s.required' =>' La descripcion  es requerida.',
             ]
             )->validate();

             $this->seccion->update($validateDate);
             $this->dispatchBrowserEvent('hide-formseccion',['message' => 'Seccion updated successfully!']);
    }

    public function confirmSeccionRemoval($seccionId)
    {
        /* dd($tag18Id); */
        $this->seccionIdBeingRemoved = $seccionId;
        $this->dispatchBrowserEvent('show-delete-modal');
    }

    public function deleteSeccion()
    {
        $seccion = Seccion::findOrFail($this->seccionIdBeingRemoved);
        $seccion->delete();
        $this->dispatchBrowserEvent('hide-delete-modal', ['message' => 'Secciones deleted successfully!']);
    }

    public function render()
    {

        $seccions =Seccion::orderBy('descripcion_s','ASC')->paginate($this->perPage);

        return view('livewire.admin.seccions.list-seccions')
        ->with('seccions',$seccions);
    }
}
