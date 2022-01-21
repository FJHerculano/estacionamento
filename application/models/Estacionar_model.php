<?php

defined('BASEPATH') OR exit('Ação não permitida');

class Estacionar_model extends CI_Model{

    public function get_all(){
        $this->db->select([
            'estacionar.*',
            'precificacoes.precificacao_id',
            'precificacoes.precificacao_categoria',
            'precificacoes.precificacao_valor_hora',
            'formas_pagamentos.forma_pagamento_id',
            'formas_pagamentos.forma_pagamento_nome',

        ]);

        $this->db->join('precificacoes', 'precificacao_id = estacionar_precificacao_id', 'LEFT');
        $this->db->join('formas_pagamentos', 'forma_pagamento_id = estacionar_forma_pagamento_id', 'LEFT');

        return $this->db->get('estacionar')->result();

    }

}