<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Common\ValidationRules;
use App\Models\Animal;

class ActiveAnimal extends Model
{
    use HasFactory;

    protected $fillable = ['animal_id', 'name', 'size', 'age'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function animal()
    {
        return $this->belongsTo(Animal::class, 'animal_id', 'id');
    }

    public static function listAll()
    {
        $data = null;
        $activeAnimals = self::queryActiveAnimal()->get();
        if (isset($activeAnimals)) {
            foreach ($activeAnimals as $item) {
                $data[$item['name']] = self::parseItemToArray($item);
            };
        }
        $result = [
            'error' => $data ? null : 'List empty',
            'data' =>  $data
        ];

        return $result;
    }

    public static function addAnimal(Array $fieldsIn)
    {
        $error = null;
        $data = null;

        $fields = ValidationRules::validateRequest( $fieldsIn,
                                [
                                    'name' => ValidationRules::NAME,
                                    'kind' => ValidationRules::KIND,
                                ]);

        if (isset($fields['fields']['kind']) && isset($fields['fields']['name'])) {
            $name = $fields['fields']['name'];
            $kind = $fields['fields']['kind'];

            $animalByName = self::getByName($name);

            if(isset($animalByName['data'])){
                $error = 'name "' . $name . '" already exists';
            }
            else {
                $animalKind = Animal::where('kind', $kind)->first();

                if (isset($animalKind)) {
                    $newData = new ActiveAnimal;
                    $newData['name'] = $name;
                    $newData['animal_id'] = $animalKind['id'];
                    $newData['size'] = 1;
                    $newData['age'] = 1;
                    $newData->save();

                    $data = self::getByName($name);
                    $data = $data['data'];
                } else {
                    $error = 'kind "' . $kind . '" not found';
                }
            }
        } else {
            $error = 'input parameters error';
        }

        $result = [
            "error" => $error,
            "data" =>  $data
        ];

        return $result;
    }

    public static function queryActiveAnimal()
    {
        $query = self::with(
                                [
                                    'animal' => function($query) {
                                        $query->select(
                                                        [
                                                            'id',
                                                            'kind',
                                                            'age_max',
                                                            'size_max',
                                                            'grow_factor',
                                                            'avatar'
                                                        ]
                                                    );
                                    }
                                ]
                            )
                            ->select(
                                        [
                                            'id',
                                            'name',
                                            'size',
                                            'age',
                                            'animal_id'
                                        ]
                                    );
        return $query;
    }

    public static function requestByName(String $name)
    {
        $animalByName = null;
        if (strlen($name)) {
            $animalByName = self::queryActiveAnimal()->where('name', $name)->first();
        }
        return $animalByName;
    }

    public static function parseItemToArray($item)
    {
        $kind = Animal::kindCollectionToArray($item->animal);
        $data = [
            'name'  => $item['name'],
            'kind'  => $kind,
            'size'  => $item['size'],
            'age'   => $item['age'],
        ];
        return $data;
    }

    public static function getByName($name)
    {
        $result = null;
        $data = null;

        $validFields = ValidationRules::validateRequest(['name' => $name],
        [
            'name' => ValidationRules::NAME,
        ]);

        if (isset($validFields['error'])) {
            $errMsg = $validFields['error'];
        }
        else {
            $errMsg = 'not found' ;
            $animalByName = self::requestByName($validFields['fields']['name']);
            if (isset($animalByName)) {
                $data[$animalByName['name']] = self::parseItemToArray($animalByName);
            };
        }

        $result = [
            "error" => $data ? null : $errMsg,
            "data" =>  $data
        ];

        return  $result;
    }

    public static function upAge(Array $fields)
    {
        $errMsg = null;
        $data = null;
        $name = '';

        $validFields = ValidationRules::validateRequest($fields,
                        [
                            'name' => ValidationRules::NAME,
                        ]);

        if (isset($validFields['error'])) {
            $errMsg = $validFields['error'];
        }
        else {
            $name = $validFields['fields']['name'];
        }

        if (strlen($name)) {
            $animalByName = self::requestByName($name);
            if (isset($animalByName)) {
                $animalKind = $animalByName->animal;

                if (($animalByName->age < $animalKind->age_max) &&
                    ($animalByName->size < $animalKind->size_max)
                ) {
                    $animalByName->age++;
                    $animalByName->size = $animalByName->size + $animalKind['grow_factor'];

                    $step = ($animalKind->size_max / $animalKind->age_max) *  $animalKind->grow_factor;
                    $animalByName->size = $step * $animalByName->age;

                    if ($animalByName->size > $animalKind->size_max) {
                        $animalByName->size = $animalKind->size_max;
                    }

                    $animalByName->save();
                } else {
                    $errMsg = 'Maximum value reached';
                }
                $data = self::getByName($name);
                $data = $data['data'];
            }
            else {
                $errMsg = 'Not found';
            }
        }

        $result = [
            "error" => $errMsg,
            "data" =>  $data
        ];

        return $result;
    }

    public static function deleteByName(Array $fields)
    {
        $errMsg = null;
        $data = null;

        $validFields = ValidationRules::validateRequest($fields,
        [
            'name' => ValidationRules::NAME,
        ]);

        if (isset($validFields['error'])) {
            $errMsg = $validFields['error'];
        }
        else {
            $errMsg = 'Not found';
            $name = $validFields['fields']['name'];
            if (strlen($name)) {
                $animalByName = self::where('name', $name)->first();
                if (isset($animalByName)) {
                    $animalByName->delete();
                    $errMsg = null;
                }
            }
        }

         $result = [
            "error" => $errMsg,
            "data" =>  $data
        ];

        return $result;
    }

    public static function deleteAll()
    {
        $activeAnimals = self::all();
        if (isset($activeAnimals)) {
            foreach ($activeAnimals as $item) {
                $item->delete();
            }
        }
    }
}
