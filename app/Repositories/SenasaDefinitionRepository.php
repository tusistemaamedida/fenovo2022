<?php

namespace App\Repositories;

use App\Models\SenasaDefinition;

class SenasaDefinitionRepository extends BaseRepository {

    public function getModel(){
        return new SenasaDefinition();
    }
}
