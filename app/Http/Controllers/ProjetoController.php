<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\Projeto\ObterProjetos\Service as ObterProjetos;
use App\Services\Projeto\EditarProjetos\Service as EditarProjetos;
use App\Services\Projeto\DeletarProjeto\Service as DeletarProjeto;

class ProjetoController extends Controller
{
    public function obterProjetos(Request $request, $id_osc, ObterProjetos $service)
    {
        $id_osc = $this->ajustarParametroUrl($id_osc);
        
    	$extensaoConteudo = ['id_osc' => $id_osc];
        $this->executarService($service, $request, $extensaoConteudo);
        
        $accept = $request->header('Accept');
        $response = $this->getResponse($accept);
        
        return $response;
    }

    public function editarProjetos(Request $request, $id_osc, EditarProjetos $service)
    {
        $id_osc = $this->ajustarParametroUrl($id_osc);
        
    	$extensaoConteudo = ['id_osc' => $id_osc];
        $this->executarService($service, $request, $extensaoConteudo);
        
        $accept = $request->header('Accept');
        $response = $this->getResponse($accept);
        
        return $response;
    }

    public function deletarProjeto(Request $request, $id_projeto, $id_osc, DeletarProjeto $service)
    {
        $id_projeto = $this->ajustarParametroUrl($id_projeto);
        $id_osc = $this->ajustarParametroUrl($id_osc);
        
    	$extensaoConteudo = ['id_projeto' => $id_projeto, 'id_osc' => $id_osc];
        $this->executarService($service, $request, $extensaoConteudo);
        
        $accept = $request->header('Accept');
        $response = $this->getResponse($accept);
        
        return $response;
    }
}