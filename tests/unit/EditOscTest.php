<?php
use function GuzzleHttp\json_decode;
use Illuminate\Support\Facades\Log;

class EditOscTest extends TestCase
{
    /**
     * Return Token Login
     *
     * @return class
     */
    public function createTokenLogin()
    {
        $parameters = [
            'tx_email_usuario' => 'teste2@gmail.com',
            'tx_senha_usuario' => '654321'
        ];

        return $this->json('POST', '/api/user/login', $parameters);
    }

    /**
     * POST /api/osc/dadosgerais/789809
     *
     * @return void
     */
    public function testEditOsc()
    {
        $data = [
            "id_osc" => 789809,
            "cd_identificador_osc" => "27278461000187",
            "tx_razao_social_osc" => "Organização da Sociedade Civil de Teste do Mapa das OSCs",
            "tx_nome_fantasia_osc" => "Organização de Testeasda",
            "cd_atividade_economica_osc" => null,
            "cd_natureza_juridica_osc" => "3999",
            "tx_sigla_osc" => "orgteste",
            "bo_nao_possui_sigla_osc" => false,
            "tx_apelido_osc" => null,
            "dt_fundacao_osc" => "01-01-2000",
            "dt_ano_cadastro_cnpj" => "01-01-1999",
            "tx_nome_responsavel_legal" => "João da Silva",
            "tx_resumo_osc" => "Nosso objetivo é aprimorar o Mapa das OSCs, todo dia.",
            "cd_situacao_imovel_osc" => "1",
            "tx_endereco" => "RUA CAPITAO SILVIO GONCALVES DE FARIAS",
            "nr_localizacao" => "981",
            "tx_endereco_complemento" => "Lote 2",
            "tx_bairro" => "BOSQUE",
            "cd_municipio" => "1100155",
            "cd_uf" => "11",
            "nr_cep" => "76920000",
            "tx_email" => "mapaosc@ipea.gov.br",
            "bo_nao_possui_email" => false,
            "tx_site" => "mapaosc.ipea.gov.br",
            "bo_nao_possui_site" => false,
            "tx_telefone" => "(24) 3515-5666",
            "objetivo_metas" => [
                [
                    "id_objetivo_osc" => 500,
                    "cd_objetivo_osc" => 2,
                    "cd_meta_osc" => "2.1"
                ],
                [
                    "id_objetivo_osc" => 501,
                    "cd_objetivo_osc" => 3,
                    "cd_meta_osc" => "3.1"
                ],
                [
                    "id_objetivo_osc" => 502,
                    "cd_objetivo_osc" => 3,
                    "cd_meta_osc" => "3.2"
                ]
            ],
        ];

        $user = $this->createTokenLogin();
        $this->refreshApplication();
        $token = json_decode($user->response->original);

        $headers = [
            'Authorization' => $token->access_token
        ];

        try {
            $user = $this->json('POST', '/api/osc/dadosgerais/789809', $data, $headers);
            $user->seeStatusCode(200);
        } catch (\Exception $e) {
            Log::warning('Falha ao fazer requisição para rota "/api/osc/dadosgerais/789809".' . "\n");
            Log::error($e->getMessage());
            echo ("Erro a editar osc `/api/osc/dadosgerais/789809`, consulte o log!!!");
            return die;
        }
    }

    /**
     * POST /api/user/governo/3
     *
     * @return void
     */
    public function testUserGoverno()
    {
        $data = [
            "id_usuario" => 2,
            "tx_email_usuario" => "teste3@gmails.com",
            "tx_senha_usuario" => "123456",
            "tx_nome_usuario" => "Municipio",
            "tx_telefone_1" => "12345678",
            "tx_telefone_2" => "987654321",
            "localidade" => 1100015,
            "tx_orgao_usuario" => "Órgão Municipal",
            "tx_dado_institucional" => "123456",
            "tx_email_confirmacao" => "testeconfirmacao@gmail.com",
            "bo_lista_email" => true,
            "bo_lista_atualizacao_anual" => true,
            "bo_lista_atualizacao_trimestral" => true
        ];

        $user = $this->createTokenLogin();
        $this->refreshApplication();
        $token = json_decode($user->response->original);

        $headers = [
            'Authorization' => $token->access_token
        ];

        try {
            $user = $this->json('POST', '/api/user/governo/3', $data, $headers);
            $user->seeStatusCode(200);
            $detail = json_decode($user->response->original);
            print_r($detail);
        } catch (\Exception $e) {
            Log::warning('Falha ao fazer requisição para rota "/api/user/governo/3".' . "\n");
            Log::error($e->getMessage());
            echo ("Erro a fazer a requisição `/api/user/governo/3`, consulte o log!!!");
            return die;
        }
    }
}
