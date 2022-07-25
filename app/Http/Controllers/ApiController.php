<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class ApiController extends BaseController
{
    public function getPokemon(){
        $url = "https://pokeapi.co/api/v2/pokemon/";
        $pokemons_share = [
            'ditto', 'charmander', 'lucario', 'lotad', 'snorlax'
        ];
        $json_return = [];

        foreach ($pokemons_share as $poke) {
            $ch = curl_init($url.$poke);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $json_return[$poke] = $this->pokemonModific(json_decode(curl_exec($ch)));
            curl_close($ch);
        }

        return $json_return;
    }

    public function pokemonModific($pokemon){
        $newFormat = (object) [];
        
        $newFormat->id = $pokemon->id;
        if(!empty($pokemon->held_items)){
            $newFormat->rarity = $pokemon->held_items[0]->version_details[0]->rarity;
        }
        $newFormat->types = $pokemon->types;
        $newFormat->sprites = (object) [];
        $newFormat->sprites->front = $pokemon->sprites->front_default;
        $newFormat->sprites->back = $pokemon->sprites->back_default;
        
        $newFormat->stats = (object) [];
        foreach ($pokemon->stats as $stats) {
            if($stats->stat->name == "hp"){
                $newFormat->stats->hp =  $stats->base_stat;
            }
            if($stats->stat->name == "attack"){
                $newFormat->stats->attack =  $stats->base_stat;
            }
            if($stats->stat->name == "defense"){
                $newFormat->stats->defense =  $stats->base_stat;
            }
            if($stats->stat->name == "special-attack"){
                $newFormat->stats->special_attack =  $stats->base_stat;
            }
            if($stats->stat->name == "special-defense"){
                $newFormat->stats->special_defense =  $stats->base_stat;
            }
            if($stats->stat->name == "speed"){
                $newFormat->stats->speed =  $stats->base_stat;
            }
        }
        $newFormat->moves = (object) [];
        foreach ($pokemon->moves as $moves => $key) {
            $newFormat->moves = [
                'name' => $key->move->name,
                'level_learned_at' => isset($key->version_group_details[$moves]->level_learned_at) ? $key->version_group_details[$moves]->level_learned_at : null
            ];
        }
        
        return $newFormat;

    }
}
