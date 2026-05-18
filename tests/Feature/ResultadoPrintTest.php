<?php

namespace Tests\Feature;

use App\Models\Examen;
use App\Models\ExamenGrupo;
use App\Models\ExamenVariante;
use App\Models\NivelReferencia;
use App\Models\OrdenLaboratorio;
use App\Models\Paciente;
use App\Models\RegisteredDevice;
use App\Models\TipoMuestra;
use App\Models\UnidadMedida;
use App\Models\User;
use App\Models\ValorReferencia;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\PdfBuilder;
use Tests\TestCase;

class ResultadoPrintTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_it_renders_printable_results_grouped_by_exam_group(): void
    {
        ['user' => $user, 'fingerprint' => $fingerprint, 'orden' => $orden] = $this->crearOrdenConResultados();

        $response = $this
            ->actingAs($user)
            ->withCookie(config('shadai.device_cookie'), $fingerprint)
            ->get(route('resultados.imprimir', $orden));

        $response
            ->assertOk()
            ->assertSeeInOrder(['Prueba', 'Valor de referencia', 'Resultado'])
            ->assertSee('Quimica Sanguinea')
            ->assertSee('Proteinas Totales')
            ->assertSee('8.39 mg/dL')
            ->assertSee('Adultos: 6.80 - 8.70 mg/dL');

        $orden->refresh();

        $this->assertTrue($orden->resultado_impreso);
        $this->assertSame(1, $orden->cantidad_impresiones_resultado);
    }

    public function test_it_returns_a_pdf_response_for_results(): void
    {
        Pdf::fake();

        ['user' => $user, 'fingerprint' => $fingerprint, 'orden' => $orden] = $this->crearOrdenConResultados();

        $response = $this
            ->actingAs($user)
            ->withCookie(config('shadai.device_cookie'), $fingerprint)
            ->get(route('resultados.pdf', $orden));

        $response->assertOk();

        Pdf::assertRespondedWithPdf(function (PdfBuilder $pdf) use ($orden): bool {
            return $pdf->viewName === 'prints.resultados-examen'
                && $pdf->downloadName === "resultados-orden-{$orden->id}.pdf"
                && $pdf->format === 'letter'
                && $pdf->margins === [
                    'top' => 0.0,
                    'right' => 0.0,
                    'bottom' => 0.0,
                    'left' => 0.0,
                    'unit' => 'mm',
                ]
                && $pdf->contains(['Quimica Sanguinea', 'Proteinas Totales', '8.39 mg/dL']);
        });

        $orden->refresh();

        $this->assertTrue($orden->resultado_impreso);
        $this->assertSame(1, $orden->cantidad_impresiones_resultado);
    }

    /**
     * @return array{user: User, fingerprint: string, orden: OrdenLaboratorio}
     */
    private function crearOrdenConResultados(): array
    {
        $user = User::create([
            'nombre' => 'Recepcion',
            'usuario' => 'recepcion',
            'correo' => 'recepcion@example.com',
            'password' => 'password',
            'rol' => 'USUARIO',
            'estado' => true,
        ]);

        $fingerprint = 'testing-device';

        RegisteredDevice::create([
            'usuario_id' => $user->id,
            'nombre' => 'Equipo de prueba',
            'fingerprint_hash' => hash('sha256', $fingerprint),
            'registro_token_hash' => hash('sha256', 'token'),
            'ip_registro' => '127.0.0.1',
            'user_agent_registro' => 'PHPUnit',
            'registrado_at' => now(),
            'estado' => true,
        ]);

        $paciente = Paciente::create([
            'docid' => '0801199012345',
            'nombres' => 'Ana',
            'apellidos' => 'Lopez',
            'fecha_nacimiento' => now()->subYears(35)->toDateString(),
            'sexo' => 'FEMENINO',
            'estado' => true,
        ]);

        $grupo = ExamenGrupo::create([
            'nombre' => 'Quimica Sanguinea',
            'orden' => 1,
        ]);
        $tipoMuestra = TipoMuestra::create(['nombre' => 'Sangre']);
        $unidad = UnidadMedida::create([
            'simbolo' => 'mg/dL',
            'nombre' => 'Miligramos por decilitro',
        ]);
        $nivel = NivelReferencia::create(['nombre' => 'Adultos']);

        $examen = Examen::create([
            'grupo_id' => $grupo->id,
            'tipo_muestra_id' => $tipoMuestra->id,
            'nombre' => 'Proteinas',
            'requiere_ayuno' => false,
            'requiere_muestra' => true,
            'tiempo_entrega_horas' => 24,
            'orden' => 1,
            'estado' => true,
        ]);

        $variante = ExamenVariante::create([
            'examen_id' => $examen->id,
            'unidad_medida_id' => $unidad->id,
            'nombre' => 'Proteinas Totales',
            'tipo_resultado' => 'NUMERICO',
            'decimales' => 2,
            'estado' => true,
        ]);

        $referencia = ValorReferencia::create([
            'variante_id' => $variante->id,
            'nivel_id' => $nivel->id,
            'sexo' => 'AMBOS',
            'operador' => 'RANGO',
            'valor_min' => 6.8,
            'valor_max' => 8.7,
            'unidad' => 'mg/dL',
            'estado' => true,
        ]);

        $orden = OrdenLaboratorio::create([
            'paciente_id' => $paciente->id,
            'usuario_id' => $user->id,
            'fecha_orden' => now(),
            'estado' => 'FINALIZADA',
            'prioridad' => 'NORMAL',
            'resultado_impreso' => false,
            'cantidad_impresiones_resultado' => 0,
        ]);

        $ordenExamen = $orden->examenesOrdenados()->create([
            'examen_id' => $examen->id,
            'nombre_examen_snapshot' => $examen->nombre,
            'tipo_muestra_snapshot' => $tipoMuestra->nombre,
            'requiere_ayuno_snapshot' => false,
            'tiempo_entrega_horas_snapshot' => 24,
            'estado' => 'FINALIZADO',
        ]);

        $ordenExamen->resultados()->create([
            'variante_id' => $variante->id,
            'valor_referencia_id' => $referencia->id,
            'resultado_numero' => 8.39,
            'unidad' => 'mg/dL',
            'variante_nombre_snapshot' => 'Proteinas Totales',
            'ref_nivel_nombre' => 'Adultos',
            'ref_sexo' => 'AMBOS',
            'ref_operador' => 'RANGO',
            'ref_valor_min' => 6.8,
            'ref_valor_max' => 8.7,
            'ref_unidad' => 'mg/dL',
            'estado_resultado' => 'NORMAL',
        ]);

        return [
            'user' => $user,
            'fingerprint' => $fingerprint,
            'orden' => $orden,
        ];
    }
}
