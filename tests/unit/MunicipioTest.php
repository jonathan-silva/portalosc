<?php

use Illuminate\Support\Facades\Log;

class MunicipioTest extends TestCase
{
    /**
     * API Municipio
     * /api/geo/cluster/municipio
     */
    public function testGetMunicipio()
    {
        try {
            $this->get("/api/geo/cluster/municipio");
            $this->seeStatusCode(200);
            $this->seeJsonStructure([
                '*' => [
                    'id_regiao',
                    'tx_nome_regiao',
                    'tx_sigla_regiao',
                    'geo_lat_centroid_regiao',
                    'geo_lng_centroid_regiao',
                    'nr_quantidade_osc_regiao'
                ]
            ]);
            echo ("### Buscar todos municipios '/api/geo/cluster/municipio' OK ###.. \n");
            echo ("..### Requisição feita com sucesso !!! ### \n");
            return true;
        } catch (\Exception $e) {
            Log::warning('Falha ao fazer requisição para rota "/api/geo/cluster/municipio".' . "\n");
            echo ("Erro a fazer a requisição, consulte o log!!!");
            return die;
        }
    }

    /**
     * Pesquisar Município
     * /api/menu/geo/municipio/{nome_municipio}
     * @param {nome_municipio} Luziania
     * @param {nome_municipio} Teresina
     * @param {nome_municipio} Goiania
     * @param {nome_municipio} Brasilia
     */
    public function testSearchMunicipio()
    {
        try {
            $this->get("/api/menu/geo/municipio/Luziania");
            $this->seeStatusCode(200);
            $this->seeJsonStructure([
                '*' => [
                    'edmu_cd_municipio',
                    'edmu_nm_municipio',
                    'eduf_sg_uf'
                ]
            ]);
            $this->get("/api/menu/geo/municipio/Teresina");
            $this->seeStatusCode(200);
            $this->seeJsonStructure([
                '*' => [
                    'edmu_cd_municipio',
                    'edmu_nm_municipio',
                    'eduf_sg_uf'
                ]
            ]);
            $this->get("/api/menu/geo/municipio/Goiania");
            $this->seeStatusCode(200);
            $this->seeJsonStructure([
                '*' => [
                    'edmu_cd_municipio',
                    'edmu_nm_municipio',
                    'eduf_sg_uf'
                ]
            ]);
            $this->get("/api/menu/geo/municipio/Brasilia");
            $this->seeStatusCode(200);
            $this->seeJsonStructure([
                '*' => [
                    'edmu_cd_municipio',
                    'edmu_nm_municipio',
                    'eduf_sg_uf'
                ]
            ]);
            $this->assertTrue(true);
            echo ("### Pesquisar por municipio '/api/menu/geo/municipio/{nome_municipio}' OK ###.. \n");
            echo ("..### Requisição feita com sucesso !!! ###");
        } catch (\Exception $e) {
            Log::warning('Falha ao fazer requisição para rota "/api/menu/geo/municipio/{nome_municipio}".' . "\n");
            echo ("Erro ao trazer os municipios, consulte o log!!!");
            return die;
        }
    }
}