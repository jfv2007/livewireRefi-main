<?php

namespace App\Http\Livewire\Admin\Categorias;

use App\Models\Categoria;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ListCategorias extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $state=[];

     public $categoria;
    public $showEditModal = false;

    protected $listeners = ['deleteConfirmed' => 'deleteCategoria'];
    public $categoriaIdBeingRemoved = null;

    public $perPage = 10;


    public function addNewCategoria()
    {
         /* dd('here'); */
         $this->state = [];
         $this->dispatchBrowserEvent('show-formcategoria');
    }

    public function createCategoria()
    {
         /* dd($this->selectedCentroModal); */
          /* dd($this->state);  */

        $validateDate= Validator::make(
            $this->state,
            [
                'descripcion_c'=>'required',

             ],
             [
                'descripcion_c.required' =>' La descripcion es requerido.',

             ]
             )->validate();

             $validateDate['descripcion_c'] = strtoupper($this->state['descripcion_c']);/*convierte a mayuscula el registro tag */



             Categoria::create($validateDate);
             $this->dispatchBrowserEvent('hide-formcategoria',['message' => 'Se agrego planta satisfactoriamente!'] );

             return redirect()->back();
    }

    public function edit(Categoria $categoria)
    {
         /* dd($tag18); */
        $this->showEditModal=true;

        $this->categoria=$categoria;
        $this->state=$categoria->toArray();

        /* $this->modalplantas =Planta::all(); */

        $this->dispatchBrowserEvent('show-formcategoria');
    }

    public function updateCategoria()
    {  /* dd('here');  */
        $validateDate= Validator::make(
            $this->state,
            [
                'descripcion_c'=>'required',
             ],
             [
                'descripcion_c.required' =>' La descripcion  es requerida.',
             ]
             )->validate();

             $this->categoria->update($validateDate);
             $this->dispatchBrowserEvent('hide-formcategoria',['message' => 'Categoria updated successfully!']);
    }

    public function confirmCategoriaRemoval($categoriaId)
    {
        /* dd($tag18Id); */
        $this->categoriaIdBeingRemoved = $categoriaId;
        $this->dispatchBrowserEvent('show-delete-modal');
    }

    public function deleteCategoria()
    {
        $categoria = Categoria::findOrFail($this->categoriaIdBeingRemoved);
        $categoria->delete();
        $this->dispatchBrowserEvent('hide-delete-modal', ['message' => 'Categoria deleted successfully!']);
    }


    public function render()
    {

        $categorias =Categoria::orderBy('descripcion_c','ASC')->paginate($this->perPage);

        return view('livewire.admin.categorias.list-categorias')
        ->with('categorias',$categorias);
    }
}
