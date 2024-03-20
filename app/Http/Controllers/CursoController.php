<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCurso;
use App\Http\Requests\UpdateCurso;
use App\Models\Curso;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Http\Request;

class CursoController extends Controller
{   
    public function index(){
        $cursos = Curso::orderBy('id', 'desc')->paginate();
        return view('cursos.index', compact('cursos'));
    }
    public function create(){
        return view('cursos.create');
    }

    public function store(StoreCurso $request){
        $curso = Curso::create($request->all());
        return redirect()->route('cursos.show', $curso);
    }

    public function show(Curso $curso){
        return view('cursos.show', compact('curso'));
    }

    public function edit(Curso $curso){
        return view('cursos.edit', compact('curso'));
    }

    public function update(Request $request, Curso $curso){
        // $curso->update($request->all());
        $request->validate([
            'name' => 'required|min:3',
            'slug' => 'required|unique:cursos,slug, ' . $curso->id,
            'descripcion' => 'required',
            'categoria' => 'required'
        ]);

        return redirect()->route('cursos.show', $curso);
    }
    
    public function destroy(Curso $curso){
        $curso->delete();
        return redirect()->route('cursos.index', $curso);
    }

}
