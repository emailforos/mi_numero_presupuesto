<?php
/*
 * This file is part of FacturaSctipts
 * Copyright (C) 2014-2016    Carlos Garcia Gomez        neorazorx@gmail.com
 * Copyright (C) 2014         Francesc Pineda Segarra    shawe.ewahs@gmail.com
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once 'plugins/presupuestos_y_pedidos/model/core/presupuesto_cliente.php';

/**
 * Presupuesto de cliente
 */
class presupuesto_cliente extends FacturaScripts\model\presupuesto_cliente
{
    public function new_codigo() {
        
      $sec = new secuencia();
      $sec = $sec->get_by_params2($this->codejercicio, "A", 'npresupuestocli');
      if($sec)
      {
         $this->numero = $sec->valorout;
         $sec->valorout++;
         $sec->save();
      }

      if(!$sec OR $this->numero <= 1)
      {
         // viejo $numero = $this->db->select("SELECT MAX(" . $this->db->sql_to_int('numero') . ") as num FROM " . $this->table_name . " WHERE codejercicio = " . $this->var2str($this->codejercicio) . " AND codserie = " . $this->var2str($this->codserie) . ";");
         // nuevo 
         $numero = $this->db->select("SELECT MAX(" . $this->db->sql_to_int('numero') . ") as num FROM " . $this->table_name . " WHERE codejercicio = " . $this->var2str($this->codejercicio) . " AND codserie = ".'A'.";");
            if($numero)
         {
            $this->numero = 1 + intval($numero[0]['num']);
         }
         else
            $this->numero = 1;

         if($sec)
         {
            $sec->valorout = 1 + $this->numero;
            $sec->save();
         }
      }
      // inicio nuevo
      $temp =  substr($this->codejercicio, -2);
      // fin nuevo
      if(FS_NEW_CODIGO == 'eneboo')
      {
         //$this->codigo = $this->codejercicio.sprintf('%02s', $this->codserie).sprintf('%06s', $this->numero);
          $this->codigo = $temp.'-'.sprintf('%04s', $this->numero);
      }
      else
      {
         //$this->codigo = strtoupper(substr(FS_PRESUPUESTO, 0, 3)).$this->codejercicio.$this->codserie.$this->numero;
                   $this->codigo = $temp.'-'.sprintf('%04s', $this->numero);

      }
    }
}
