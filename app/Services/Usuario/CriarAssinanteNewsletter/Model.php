<?php

namespace App\Services\Usuario\CriarAssinanteNewsletter;

use App\Services\BaseModel;

class Model extends BaseModel
{
	private $tx_email_usuario = array(
		'apelidos'		=> ['tx_email_usuario', 'email_usuario', 'emailUsuario', 'email'], 
        'obrigatorio'	=> true, 
        'tipo'			=> 'email'
	);

	private $tx_nome_usuario = array(
		'apelidos'		=> ['tx_nome_usuario', 'nome_usuario', 'nomeUsuario', 'nome'], 
        'obrigatorio'	=> true, 
        'tipo'			=> 'string'
	);
	
    public function __construct($requisicao = null)
    {
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}