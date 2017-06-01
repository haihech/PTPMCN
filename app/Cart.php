<?php

namespace App;

class Cart
{
    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;
    public $listSp=[];
    public $listNum=[];
   
    public function __construct($oldCart){
        if($oldCart){
            // $this->items = $oldCart->items;
            // $this->totalQty = $oldCart->totalQty;
            // $this->totalPrice = $oldCart->totalPrice;
            $this->listSp=$oldCart->listSp;
            $this->listNum=$oldCart->listNum;
    
        }

    }
    public function addSp($id,$num){
        foreach ($this->listSp as $key => $sp) {
            if($sp==$id){
                $this->listNum[$key]+=$num;
                return;
            }
        }
        array_push($this->listSp,$id );
        array_push($this->listNum,$num );
    }
    public function add($item, $id, $num){
        $storedItem = ['qty' => 0, 'price' => $item->giaban, 'item' => $item ];
        if($this->items){ 
            if(array_key_exists($id, $this->items)){
                $storedItem = $this->items[$id];
            }

        }
        $storedItem['qty'] += $num;
        $storedItem['price'] = $item->giaban - $item->discount;
        $this->items[$id] = $storedItem;
        $this->totalQty += $num;
        $this->totalPrice += $storedItem['price'] * $num;
    }

}
