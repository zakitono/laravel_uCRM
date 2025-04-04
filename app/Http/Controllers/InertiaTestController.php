<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\In;
use Inertia\Inertia;
use App\Models\InertiaTest;


class InertiaTestController extends Controller
{
    public function index(){
        return Inertia::render('Inertia/Index', [
            'blogs' => InertiaTest::all()
        ]);
    }

    public function create(){
        return Inertia::render('Inertia/Create');
    }


    public function show($id){
        return Inertia::render('Inertia/Show',
        [
            'id' => $id,
            'blog' => InertiaTest::findOrFail($id)
        ]);
    }

    public function  store(Request $request){
            $validated = $request->validate([
                'title' => ['required', 'max:255'],
                'content' => ['required'],
            ]);

            InertiaTest::create($validated);

            return redirect()->route('inertia.index')->with([
                'message' => '登録しました！'
            ]);
        }
    public function delete($id){

        $book = InertiaTest::findOrFail($id);
        $book->delete();

        return redirect()->route('inertia.index')->with([
            'message' => '削除しました！'
        ]);
    }
}
