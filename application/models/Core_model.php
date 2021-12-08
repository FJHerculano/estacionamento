<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Core_model extends CI_Model{
   
    //busca todos os dados do banco 
    public function get_all($table = NULL, $condition = NULL){
        // condição de existencia da tabela
        if($table && table_exists($table)){
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
        if($table && table_exists($table) && is_array($condition)) {
            $this->db->where($condition);
            $this->db->limit(1);

            return $this->db->get($table)->row();
        // Caso não exista     
        } else{
            return FALSE;
        }   
    }

    public function insert($table = NULL, $data = NULL){

         // condição de existencia da tabela e se é um  array
         if($table && table_exists($table) && is_array($data)) {

            $this->db->insert($table, $data);

            if($this->db->affected_rows() > 0){
                $this->session->set_flashdata('sucesso', 'Dados salvos com sucesso!');
            }else{
                $this->session->set_flashdata('error', 'Não foi possivel salvar os dados!');
            }

         } else {
             return false;
         }
    }

    public function update($table = NULL , $data = NULL, $condition = NULL){
        if($table && table_exists($table) && is_array($data) && is_array($condition)){

            if($this->db->update($table, $data, $condition)){

                $this->session->set_flashdata('sucesso', 'Dados salvos com sucesso');

            } else {

                $this->session->set_flashdata('error', 'Não foi possivel salvar os dados');

            } 

        }else{
            return FALSE;
        }
    }

    public function delete($table = NULL , $condition = NULL){

        if($table && table_exists($table) && is_array($condition)){

            if($this->db->delete($table, $condition)){

                $this->session->set_flashdata('sucesso', 'Registro excluido com sucesso!');

            }else{
                $this->session->set_flashdata('error', 'Não foi possivel apagar o usuario!');
            }

        }else{
            return FALSE;
        }
    }

}