<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public static function addAnimal(Array $fields)
    {
        $error = null;
        $data = null;

        if (isset($fields['fields']['kind']) && isset($fields['fields']['name'])) {
            $name = $fields['fields']['name'];
            $kind = $fields['fields']['kind'];
            $animalByName = self::getByName($name);
            if (!is_array($animalByName)) {
                unset($animalByName);
                $animalKind = Animal::where('kind', $kind)->first();
                if (isset($animalKind)) {
                    $newData = new ActiveAnimal;
                    $newData['name'] = $name;
                    $newData['animal_id'] = $animalKind['id'];
                    $newData['size'] = 1;
                    $newData['age'] = 1;
                    $newData->save();

                    $data = self::getByName($name);
                } else {
                    $error = 'kind "' . $kind . '" not found';
                }
            } else {
                $error = 'name "' . $name . '" already exists';
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

    public static function getByName(String $name, bool $enableWraper=false)
    {
        $result = null;
        $data = null;
        $animalByName = self::requestByName($name);
        if (isset($animalByName)) {

            $data[$animalByName['name']] = self::parseItemToArray($animalByName);
        };

        if ($enableWraper) {
            $result = [
                "error" => $data ? null : "not found",
                "data" =>  $data
            ];
        } else {
            $result = $data;
        }

        return  $result;
    }

    public static function upAge(String $name)
    {
        $errMsg = null;
        $data = null;
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

    public static function deleteByName(String $name)
    {
        $res = false;
        if (strlen($name)) {
            $animalByName = self::where('name', $name)->first();
            if (isset($animalByName)) {
                $animalByName->delete();
                $res = true;
            }
        }
        return $res;
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
