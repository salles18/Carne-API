<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;

class CarneController extends Controller
{
    private $carneData = [];

    public function create(Request $request)
    {
        $data = $request->validate([
            'valor_total' => 'required|numeric',
            'qtd_parcelas' => 'required|integer|min:1',
            'data_primeiro_vencimento' => 'required|date_format:Y-m-d',
            'periodicidade' => 'required|in:mensal,semanal',
            'valor_entrada' => 'nullable|numeric',
        ]);

        $valorTotal = $data['valor_total'];
        $qtdParcelas = $data['qtd_parcelas'];
        $dataPrimeiroVencimento = $data['data_primeiro_vencimento'];
        $periodicidade = $data['periodicidade'];
        $valorEntrada = $data['valor_entrada'] ?? 0;

        $parcelas = [];
        $valorParcelado = ($valorTotal - $valorEntrada) / $qtdParcelas;

        if ($valorEntrada > 0) {
            $parcelas[] = [
                'data_vencimento' => $dataPrimeiroVencimento,
                'valor' => $valorEntrada,
                'numero' => 1,
                'entrada' => true
            ];
            $numeroParcela = 2;
        } else {
            $numeroParcela = 1;
        }

        for ($i = 0; $i < $qtdParcelas; $i++) {
            $dataVencimento = $this->calcularProximaData($dataPrimeiroVencimento, $periodicidade, $i);
            $parcelas[] = [
                'data_vencimento' => $dataVencimento,
                'valor' => round($valorParcelado, 2),
                'numero' => $numeroParcela++
            ];
        }

        $carne = [
            'total' => $valorTotal,
            'valor_entrada' => $valorEntrada,
            'parcelas' => $parcelas
        ];

        // Simulação de salvamento em memória
        $id = count($this->carneData) + 1;
        $this->carneData[$id] = $carne;

        return response()->json($carne);
    }

    public function show($id)
    {
        // Recupera as parcelas pelo ID (simulação)
        if (isset($this->carneData[$id])) {
            return response()->json($this->carneData[$id]['parcelas']);
        }

        return response()->json(['error' => 'Carnê não encontrado'], 404);
    }

    private function calcularProximaData($dataInicial, $periodicidade, $indice)
    {
        $data = new DateTime($dataInicial);

        if ($periodicidade === 'mensal') {
            $data->modify("+$indice month");
        } elseif ($periodicidade === 'semanal') {
            $data->modify("+$indice week");
        }

        return $data->format('Y-m-d');
    }
}
