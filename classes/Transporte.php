<?php

Class Transporte 
{
    
    private $orcamentosTransportadoras = array();

    public function __construct()
    {
        //Apenas para agilizar
        $this->orcamentosTransportadoras["boaDex"]          = (object)array("valorFixo" => 1000, "valorKmKg" => 5, "pesoMin" => null, "pesoMax" => null);
        $this->orcamentosTransportadoras["boaLog"]          = (object)array("valorFixo" => 430, "valorKmKg" => 12, "pesoMin" => null, "pesoMax" => null);
        $this->orcamentosTransportadoras["transboaLight"]   = (object)array("valorFixo" => 210, "valorKmKg" => 110, "pesoMin" => null, "pesoMax" => 5);
        $this->orcamentosTransportadoras["transboaHeavy"]   = (object)array("valorFixo" => 1000, "valorKmKg" => 1, "pesoMin" => 5, "pesoMax" => null);
    }

    private function validarPeso($transportadora = null, $mercadoria = null)
    {
        if($transportadora == null){
            return "Por favor, informe a transportadora.";
        }

        else if($mercadoria == null){
            return "Por favor, informe a mercadoria.";
        }

        $t = (object)$transportadora;
        $validado = true;

        if($t->pesoMin !== null){
            if($mercadoria->peso < $t->pesoMin){
                $validado = false;
            }
        }
        else if($t->pesoMax !== null){
            if($mercadoria->peso > $t->pesoMax){
                $validado = false;
            }
        }

        return $validado;
    }

    public function calcularTransporte($mercadorias = null)
    {
        if($mercadorias == null){
            return "Por favor, informe a mercadoria.";
        }

        foreach($mercadorias as $mercadoria)
        {
            $i = 0;
            foreach($this->orcamentosTransportadoras as $key => $transportadora){
                if($this->validarPeso($transportadora, $mercadoria)){
                    $calculo = $transportadora->valorFixo + ($mercadoria->peso * $mercadoria->distancia * $transportadora->valorKmKg);
                    $mercadoria->orcamentosTransportadoras[$i] = array("nome" => $key, "orcamento" => $calculo);
                    $i++;
                }
            }

            $this->ordenarTransporteBarato($mercadoria);
            $mercadoria->transporteMaisBarato = $mercadoria->orcamentosTransportadoras[0];
        }

        return $mercadorias;
    }

    public function ordenarTransporteBarato($mercadoria = null)
    {
        foreach ($mercadoria->orcamentosTransportadoras as $key => $row) {
            $orcamento[$key]  = $row['orcamento'];
            $nome[$key] = $row['nome'];
        }
        
        array_multisort($orcamento, SORT_ASC, $nome, SORT_DESC, $mercadoria->orcamentosTransportadoras);
        return $mercadoria;
    }

}

?>