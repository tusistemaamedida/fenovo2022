<?php

namespace App\Repositories;

use App\Models\AlicoutaType;

class AlicuotaTypeRepository extends BaseRepository {

    public function getModel(){
        return new AlicoutaType();
    }
}
