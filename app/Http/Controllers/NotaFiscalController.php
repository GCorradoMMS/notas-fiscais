<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NotaFiscalRequest;
use App\Models\NotaFiscal;
use App\Notifications\NotaFiscalCriadaNotification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class NotaFiscalController extends Controller
{

    public function __construct() {
        $this->middleware(function ($request, $next) {
            if (!Auth::check()) {
                return response()->json(['error' => 'Usuário não autenticado.'], 401);
            }

            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index(NotaFiscal $model): \Illuminate\Http\JsonResponse
    {
        $userId = auth()->user()->id;
        return response()->json(['data' => $model->where('usuario_id', '=', $userId)->get()], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NotaFiscalRequest $request, NotaFiscal $model): \Illuminate\Http\JsonResponse
    {   
        $users = User::where('id', '=', auth()->user()->id)->get();
        $data = $this->getDataFrom($request);
        $notaFiscal = $model->create($data);

        foreach ($users as $user) {
            Notification::send($user, (new NotaFiscalCriadaNotification($user, $notaFiscal))->delay(now()->addSeconds(1)));
        }
        
        return response()->json(['data' => $notaFiscal], 201);
    }

    public function show(NotaFiscal $model, string $numero): \Illuminate\Http\JsonResponse
    {
        $userId = auth()->user()->id;
        $data = $model->where('numero', '=',  $numero)
                      ->where('usuario_id', '=', $userId)
                      ->get();

        if(!$data) {
            return response(__('fail.nota_fiscal_not_found'), 404);
        }

        return response()->json(['data' => $data], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NotaFiscalRequest $request, string $numero, NotaFiscal $model): \Illuminate\Http\JsonResponse
    {
        $userId = auth()->user()->id;
        $data = $this->getDataFrom($request);
        $updated = $model->where('numero', '=',  $numero)
                         ->where('usuario_id', '=', $userId)
                         ->update($data);

        if(!$updated) {
            return response(__('fail.nota_fiscal_not_found'), 404);
        }

        return response()->json(['data' => $updated], 200);
    }

    public function destroy(NotaFiscal $model, string $numero): \Illuminate\Http\JsonResponse
    {
        $userId = auth()->user()->id;
        $deleted = $model->where('numero', '=',  $numero)
                ->where('usuario_id', '=', $userId)
                ->delete();

        if(!$deleted) {
            return response(__('fail.nota_fiscal_not_found'), 404);
        }

        return response()->json(__('success.nota_fiscal_deleted'), 200);
    }

    private function getDataFrom(NotaFiscalRequest $request): array {
        $validated = $request->post();
        $final = [
            'numero' => $validated['numero'],
            'valor' => $validated['valor'],
            'data_emissao' => $validated['data_emissao'],
            'cnpj_remetente' => $validated['cnpj_remetente'],
            'nome_remetente' => $validated['nome_remetente'],
            'cnpj_transportador' => $validated['cnpj_transportador'],
            'nome_transportador' => $validated['nome_transportador'],
            'usuario_id' => auth()->user()->id
        ];

        return $final;
    }
}
