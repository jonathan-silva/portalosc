<?php

namespace App\Services\Usuario;

use App\Enums\NomenclaturaAtributoEnum;
use App\Enums\TipoUsuarioEnum;
use App\Services\Service;
use App\Services\Model;
use App\Dao\UsuarioDao;

class CriarRepresentanteGovernoService extends Service
{
    public function executar()
    {
        $contrato = [
            'tx_email_usuario' => ['apelidos' => NomenclaturaAtributoEnum::EMAIL, 'obrigatorio' => true, 'tipo' => 'email'],
            'tx_senha_usuario' => ['apelidos' => NomenclaturaAtributoEnum::SENHA, 'obrigatorio' => true, 'tipo' => 'senha'],
            'tx_nome_usuario' => ['apelidos' => NomenclaturaAtributoEnum::NOME_USUARIO, 'obrigatorio' => true, 'tipo' => 'string'],
            'nr_cpf_usuario' => ['apelidos' => NomenclaturaAtributoEnum::CPF, 'obrigatorio' => true, 'tipo' => 'cpf'],
            'bo_lista_email' => ['apelidos' => NomenclaturaAtributoEnum::LISTA_EMAIL, 'obrigatorio' => true, 'tipo' => 'boolean'],
            'localidade' => ['apelidos' => NomenclaturaAtributoEnum::LOCALIDADE, 'obrigatorio' => true, 'tipo' => 'localidade']
        ];
        
        $model = new Model($contrato, $this->requisicao->getConteudo());
        $flagModel = $this->analisarModel($model);
        
        if($flagModel){
            $requisicao = $this->requisicao->getConteudo();
            $requisicao->token = md5($requisicao->nr_cpf_usuario . time());
            
            $usuarioDao = new UsuarioDao();
            
            if(strlen($requisicao->localidade) == 7){
                $resultadoDao = $this->criarRepresentanteGovernoMunicipio($requisicao, $usuarioDao);
            }else if(strlen($requisicao->localidade) == 2){
                $resultadoDao = $this->criarRepresentanteGovernoEstado($requisicao, $usuarioDao);
            }
            
            if($resultadoDao->flag){
                /*
                 * TODO: Enviar e-mails
                 */
                $this->resposta->prepararResposta(['msg' => $resultadoDao->mensagem], 200);
            }else{
                $this->resposta->prepararResposta(['msg' => $resultadoDao->mensagem], 400);
            }
        }
    }
    
    private function criarRepresentanteGovernoMunicipio($requisicao, $usuarioDao){
        $requisicao->cd_tipo_usuario = TipoUsuarioEnum::GOVERNO_MUNICIPAL;
        $requisicao->cd_municipio = $requisicao->localidade;
        $usuarioDao->setRequisicao($requisicao);
        $usuarioDao->criarRepresentanteGovernoMunicipio();
        return $usuarioDao->getResposta();
    }
    
    private function criarRepresentanteGovernoEstado($requisicao, $usuarioDao){
        $requisicao->cd_tipo_usuario = TipoUsuarioEnum::GOVERNO_ESTADUAL;
        $requisicao->cd_uf = $requisicao->localidade;
        $usuarioDao->setRequisicao($requisicao);
        $usuarioDao->criarRepresentanteGovernoEstado();
        return $usuarioDao->getResposta();
    }
}
