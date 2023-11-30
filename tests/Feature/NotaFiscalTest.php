<?php

namespace Tests\Feature;

use App\Http\Requests\NotaFiscalRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class NotaFiscalTest extends TestCase
{
    
    use RefreshDatabase, WithFaker;
    /** @test */
    public function it_passes_validation_with_valid_data(): void
    {
        $request = new NotaFiscalRequest([
            'numero' => $this->faker->randomNumber(9),
            'valor' => $this->faker->randomFloat(2, 1, 1000),
            'data_emissao' => $this->faker->date,
            'cnpj_remetente' => '12345678901234', // Coloque um CNPJ válido
            'nome_remetente' => $this->faker->name,
            'cnpj_transportador' => '56789012345678', // Coloque um CNPJ válido
            'nome_transportador' => $this->faker->name,
        ]);

        $this->assertTrue($request->passes());
    }

    /** @test */
    public function it_fails_validation_with_invalid_data(): void
    {
        $this->expectException(ValidationException::class);

        $request = new NotaFiscalRequest([
        ]);

        $this->assertFalse($request->passes());
    }
}
