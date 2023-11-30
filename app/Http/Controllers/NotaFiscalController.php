<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NotaFiscalRequest;
use App\Models\NotaFiscal;
use Nette\Utils\Json;

class NotaFiscalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(NotaFiscal $model): \Illuminate\Http\JsonResponse
    {
        return response()->json(['data' => $model->all()], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NotaFiscalRequest $request, NotaFiscal $model): \Illuminate\Http\JsonResponse
    {
        $data = $this->getDataFrom($request);
        $stored = $model->create($data);
        
        return response()->json(['data' => $stored], 201);
    }

    public function show(NotaFiscal $model, string $numero): \Illuminate\Http\JsonResponse
    {
        $data = $model->where('numero', '=',  $numero)->get();

        if(!$data) {
            return response(__('fail.nota_fiscal_not_found'), 404);
        }

        return response()->json(['data' => $data], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NotaFiscalRequest $request, NotaFiscal $model): \Illuminate\Http\JsonResponse
    {
        $data = $this->getDataFrom($request);
        $updated = $model->where('numero', '=',  $data['numero'])->update($data);

        if(!$updated) {
            return response(__('fail.nota_fiscal_not_found'), 404);
        }

        return response()->json(['data' => $updated], 200);
    }

    public function destroy(NotaFiscal $model, string $numero): \Illuminate\Http\JsonResponse
    {
        $deleted = $model->where('numero', '=',  $numero)->delete();

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
