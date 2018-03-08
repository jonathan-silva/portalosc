<?php

namespace App\Models\Osc;

use App\Models\Model;

class FonteRecursosOscModel extends Model
{	
	private $fonteRecursos = array(
			'apelidos'		=> ['fonteRecursos', 'fonte_recursos', 'recursos', 'fonteRecursosOsc', 'fonte_recursos_osc', 'recursosOsc', 'recursos_osc'],
			'obrigatorio'	=> true,
			'tipo'			=> 'arrayObject',
			'modelo'		=> 'fonteRecursosAnualOsc'
	);
	
    public function __construct($requisicao = null)
    {
    	$modelo = get_object_vars($this);
    	
    	$this->configurarModelo($modelo);
    	$this->configurarRequisicao($requisicao);
    	$this->analisarRequisicao();
    }
}