<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use App\Common\ValidationRules;

class Animal extends Model
{
    use HasFactory;

    protected $table = 'animals';
    protected $primaryKey = 'id';

    protected $fillable = ['kind', 'size_max', 'age_max', 'grow_factor', 'avatar'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public const CASHE_KEY = self::class . '_all';

    public function ActiveAnimal()
    {
        return $this->hasMany(ActiveAnimal::class, 'animal_id', 'id');
    }

    public static function getAllKinds()
    {
        //$kinds = AnimalResource::collection(Animal::all());
        Cache::forget(self::CASHE_KEY); //  TODO: убрать в продакшене
        $data = Cache::rememberForever(self::CASHE_KEY, function () {

            $listKinds = self::all();
            $data = null;
            if (isset($listKinds)) {
                foreach ($listKinds as $item) {
                    $data[$item['kind']] = self::kindCollectionToArray($item);
                };
            }
            return $data;
        });
        return self::result($data, $data ? null : 'List empty');
    }

    public static function getKind(string $kind)
    {
        $data = null;

        if ( Cache::has(self::CASHE_KEY) ) {
            $list = Cache::get(self::CASHE_KEY, null);
            if( is_array($list) && isset($list[$kind])) {
                $data = $list[$kind];
            }
        } else {
            $item = self::where('kind', $kind)->first();
            $data = self::kindCollectionToArray($item);
        }

        $errMsg = $data ? null : 'not found';

        return self::result($data, $errMsg);
    }

    public static function deleteAll()
    {
        $items = self::all();
        if (isset( $items)) {
            foreach ( $items as $item) {
                $item->delete();
            }
        }
        return self::result(null, null);
    }

    public static function deleteByKind(string $kind)
    {
        $item = self::where('kind', $kind)->first();
        if (isset( $item)) {
            $item->delete();
        }
        return self::result(null, null);
    }

    public static function result($data, $errMsg)
    {
        $result = [
            'error' => $errMsg,
            'data' => $data
        ];

        return $result;
    }

    public static function kindCollectionToArray($item)
    {
        $data = [
            'kind'          => $item['kind'],
            'size_max'      => $item['size_max'],
            'age_max'       => $item['age_max'],
            'grow_factor'   => $item['grow_factor'],
            'avatar'        => self::avatarURL($item['avatar'])
        ];
        return $data;
    }

    public static function avatarURL(String $str)
    {
        return Storage::disk('avatar')->url($str) . '.png';
    }
}
