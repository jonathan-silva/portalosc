<?php

namespace App\Services\Usuario;

use App\Enums\NomenclaturaAtributoEnum;
use App\Services\Service;
use App\Services\Model;
use App\Dao\UsuarioDao;
use App\Dao\OscDao;
use App\Email\AtivacaoRepresentanteOscEmail;
use App\Email\InformeCadastroRepresentanteOscEmail;
use App\Email\InformeCadastroRepresentanteOscIpeaEmail;

class CriarRepresentanteOscService extends Service
{
    public function executar()
    {
        $contrato = [
            'tx_email_usuario' => ['apelidos' => NomenclaturaAtributoEnum::EMAIL, 'obrigatorio' => true, 'tipo' => 'email'],
            'tx_senha_usuario' => ['apelidos' => NomenclaturaAtributoEnum::SENHA, 'obrigatorio' => true, 'tipo' => 'senha'],
            'tx_nome_usuario' => ['apelidos' => NomenclaturaAtributoEnum::NOME_USUARIO, 'obrigatorio' => true, 'tipo' => 'string'],
            'nr_cpf_usuario' => ['apelidos' => NomenclaturaAtributoEnum::CPF, 'obrigatorio' => true, 'tipo' => 'cpf'],
            'bo_lista_email' => ['apelidos' => NomenclaturaAtributoEnum::LISTA_EMAIL, 'obrigatorio' => true, 'tipo' => 'boolean'],
            'representacao' => ['apelidos' => NomenclaturaAtributoEnum::REPRESENTACAO, 'obrigatorio' => true, 'tipo' => 'integer']
        ];
        
        $model = new Model($contrato, $this->requisicao->getConteudo());
        $flagModel = $this->analisarModel($model);
        
        if($flagModel){
            $requisicao = $model->getRequisicao();
			
            # Ajuste na API para facilitar a utilização do serviço pelo client do Mapa OSC
            $requisicao->representacao = [$requisicao->representacao];
            
            $requisicao->token = md5($requisicao->nr_cpf_usuario . time());
            
            $resultadoDao = (new UsuarioDao())->criarRepresentanteOsc($requisicao);
            
            if($resultadoDao->flag){
            	$confirmacaoUsuarioEmail = (new AtivacaoRepresentanteOscEmail())->enviar($requisicao->tx_email_usuario, 'Confirmação de Cadastro Mapa das Organizações da Sociedade Civil', $requisicao->tx_nome_usuario, $requisicao->token);
            	
                $nomeEmailOscs = (new OscDao())->obterNomeEmailOscs($requisicao->representacao);
                
                foreach($nomeEmailOscs as $osc) {
                    $emailIpea = 'mapaosc@ipea.gov.br';
                    $tituloEmail = 'Notificação de cadastro de representante no Mapa das Organizações da Sociedade Civil';
                    
                    if($osc->tx_email){
                        $informeIpeaEmail = (new InformeCadastroRepresentanteOscIpeaEmail())->enviar($emailIpea, $tituloEmail, $requisicao, $osc);
                        $informeOscEmail = (new InformeCadastroRepresentanteOscEmail())->enviar($osc->tx_email, $tituloEmail, $requisicao, $osc->tx_nome_osc);
                    }else{
                        $informeIpeaEmail = (new InformeCadastroRepresentanteOscIpeaEmail())->enviar($emailIpea, $tituloEmail, $requisicao, $osc);
                    }
                }
				
                $this->resposta->prepararResposta(['msg' => $resultadoDao->mensagem], 201);
            }else{
                //$this->resposta->prepararResposta(['msg' => $resultadoDao->mensagem], 400);
                $this->resposta->prepararResposta(['msg' => $resultadoDao->mensagem], 200);
            }
        }
    }
}
