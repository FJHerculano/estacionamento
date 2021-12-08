<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Core_model extends CI_Model{
   
    //busca todos os dados do banco 
    public function get_all($table = NULL, $condition = NULL){
        // condição de existencia da tabela
        if($table && $this->db->table_exists($table)){
            // é um array ?
            if(is_array($condition)){
                $this->db->where($condition);        
            }

            return $this->db->get($table)->result();
        // Caso não exista     
        } else{
            return FALSE;
        }
    }

    public function get_by_id($table = NULL, $condition = NULL){
        // condição de existencia da tabela e se é um  array
        

        if($table && $this->db->table_exists($table) && is_array($condition)) {
            $this->db->where($condition);
            $this->db->limit(1);

        // Traz apenas uma linha como resultado
            return $this->db->get($table)->row();
        // Caso não exista     
        } else{
            return FALSE;
        }   
    }

    public function insert($table = NULL, $data = NULL){

         // condição de existencia da tabela e se é um  array
         if($table && $this->db->table_exists($table) && is_array($data)) {

            // se os dados validados na linha anterior existem, é realizada uma 
            //inserção
            $this->db->insert($table, $data);

            // Verificando se o banco de dados teve alguma linha afetada
            //se for maior que zero significa que teve alteração 
            if($this->db->affected_rows() > 0){
                $this->session->set_flashdata('sucesso', 'Dados salvos com sucesso!');
            }else{
                $this->session->set_flashdata('error', 'Não foi possivel salvar os dados!');
            }

         } else {
             return false;
         }
    }

    // atualizando tabela 
    public function update($table = NULL , $data = NULL, $condition = NULL){
        if($table && $this->db->table_exists($table) && is_array($data) && is_array($condition)){

            // chamando update após a verificação ser real
            if($this->db->update($table, $data, $condition)){
                // atualizando após verificação
                $this->session->set_flashdata('sucesso', 'Dados salvos com sucesso');

            } else {

                $this->session->set_flashdata('error', 'Não foi possivel salvar os dados');

            } 

        }else{
            return FALSE;
        }
    } 

    public function delete($table = NULL , $condition = NULL){

        if($table && $this->db->table_exists($table) && is_array($condition)){

            // chama função delete após as verificações 
            if($this->db->delete($table, $condition)){
                // Resposta de aviso caso a deleção ocorra de acordo com o esperado
                $this->session->set_flashdata('sucesso', 'Registro excluido com sucesso!');

            }else{
                $this->session->set_flashdata('error', 'Não foi possivel apagar o usuario!');
            }

        }else{
            return FALSE;
        }
    }

}