<?php

namespace App\Services\Usuario\EditarRepresentanteOsc;

use App\Models\Model;

class OscModel extends Model
{
	private $id_osc = array(
		'apelidos'		=> ['id_osc', 'idOsc', 'id', 'osc'],
		'obrigatorio'	=> true,
		'tipo'			=> 'integer'
	);
	
    public function __construct($requisicao = null)
    {
    	$estrutura = get_object_vars($this);
    	
    	$this->configurarEstrutura($estrutura);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}