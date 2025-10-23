<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Game;
class GameController extends Controller
{
    public function index(){
        return response()->json([
            'message'=> 'List de games',
            'data'=> Game::all()
        ]);
    }

    public function store(Request $request){

        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'thumb' => 'nullable|url',
            'video' => 'nullable|url',
            'release_date' => 'required|date',
        ];

        $messages = [
            'name.required' => 'O nome do jogo é obrigatório.',
            'name.string' => 'O nome do jogo deve ser uma string.',
            'name.max' => 'O nome do jogo não pode exceder 255 caracteres.',
            'description.required' => 'A descrição do jogo é obrigatória.',
            'description.string'=> 'A descrição do jogo deve ser uma string.',
            'description.max' => 'A descrição do jogo não pode exceder 500 caracteres.',
            'release_date.required' => 'A data de lançamento é obrigatória.',
            'release_date.date' => 'A data de lançamento deve ser uma data válida.',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if( $validator->fails() ){
            return response()->json([
                'message' => 'Erro de validação.',
                'errors' => $validator->errors()
            ], 422);
        }


        $forms = $request->all();
        $games = new Game();
        $games->name = $forms["name"];
        $games->description = $forms["description"];
        $games->thumb = $forms["thumb"];
        $games->video = $forms["video"];
        $games->release_date = $forms["release_date"];

        if(!$games->save()){
            return response()->json([
                'message' => 'Failed to save game.',
                'data' => []
            ], 500);
        }

        return response()->json([
            'message'=> 'Game salvo com sucesso!',
            'data'=> $games
        ], 201);
}

    public function show(int $id){
        $game = Game::find($id);

        if(!$game){
            return response()->json([
                'message'=> 'Game not found.',
                'data'=> []
            ], 404);
        }

        return response()->json([
            'message'=> 'Game retrieved successfully.',
            'data'=> $game
        ], 200);
    }

    public function delete(int $id){
          $game = Game::find($id);
          if(!$game){
            return response()->json([
                'message'=> 'Game nao encontrado.',
                'data'=> []
            ], 404);
          }

          if(!$game->delete()){
            return response()->json([
                'message'=> 'Falha ao deletar o game.',
                'data'=> []
            ], 500);
          }

          return response()->json([
            'message'=> 'Game deletado com sucesso.',
            'data'=> []
          ], 200);
          //
    }

    public function update(int $id, Request $request){
         $rules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'thumb' => 'nullable|url',
            'video' => 'nullable|url',
            'release_date' => 'required|date',
        ];

        $messages = [
            'name.required' => 'O nome do jogo é obrigatório.',
            'name.string' => 'O nome do jogo deve ser uma string.',
            'name.max' => 'O nome do jogo não pode exceder 255 caracteres.',
            'description.required' => 'A descrição do jogo é obrigatória.',
            'description.string'=> 'A descrição do jogo deve ser uma string.',
            'description.max' => 'A descrição do jogo não pode exceder 500 caracteres.',
            'release_date.required' => 'A data de lançamento é obrigatória.',
            'release_date.date' => 'A data de lançamento deve ser uma data válida.',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if( $validator->fails() ){
            return response()->json([
                'message' => 'Erro de validação.',
                'errors' => $validator->errors()
            ], 422);
        }



        $games = Game::find($id);
        $games-> name = $request->input('name');
        $games-> description = $request->input('description');
        $games-> thumb = $request->input('thumb');
        $games-> video = $request->input('video');
        $games-> release_date = $request->input('release_date');


        if(!$games->save()){
            return response()->json([
                'message' => 'Failed to save game.',
                'data' => []
            ], 500);
        }

        return response()->json([
            'message'=> 'Game salvo com sucesso (update)!',
            'data'=> $games
        ], 201);
    }
}
