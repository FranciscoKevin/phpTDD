<?php

namespace App\Validation;

use App\Htpp\Request;
use App\Htpp\Response;

class RequestValidator
{
    /**
     * Indique si les champs sont valide
     *
     * @param Request $request
     * @param array $requiredFields
     * @return Response|null
     */
    public function validateFields(Request $request, array $requiredFields): ?Response
    {
        $invalidFields = [];

        foreach($requiredFields as $field) {
            if ($request->get($field) === null){
                $invalidFields[] = $field;
            }
        }

        if (empty($invalidFields)){
            return null;
        }

        if (count($invalidFields) === 1){
            $field = $invalidFields[0];
            return new Response("Le champ $field est manquant", [], 400);
        }

        //Formatage de la chaine si les deux chammps sont manquants
        return new Response(sprintf("Les champs %s sont manquants", implode(', ', $invalidFields)), [], 400 );
    }
}
