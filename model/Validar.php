<?php
class Validar
{
    private $alias;
    private $clave;
    public function __construct($alias,$clave)
    {
        $this->alias = $alias;
        $this->clave=$clave;
    }
    /**
     * Get the value of alias
     */ 
    public function getAlias()
    {
        return $this->alias;
    }
    /**
     * Set the value of alias
     *
     * @return  self
     */ 
    public function setAlias($alias)
    {
        $this->alias = $alias;
        return $this;
    }
    /**
     * Get the value of clave
     */ 
    public function getClave()
    {
        return $this->clave;
    }
    /**
     * Set the value of clave
     *
     * @return  self
     */ 
    public function setClave($clave)
    {
        $this->clave = $clave;
        return $this;
    }
}
