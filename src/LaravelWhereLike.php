<?php

namespace Diarsa\LaravelWhereLike;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class LaravelWhereLike
{

    public function __construct() {
    }

    public static function tambah($a, $b) {
        return $a + $b;
    }

    public static function register()
    {
        /**
         * Custom macro whereLike => Searching models using a where like query in Laravel, event for encrypted fields
         * @param array|string $attributes
         * @param string $searchTerm
         * @return Builder
         */
        Builder::macro('whereLike', function ($attributes, string $searchTerm) {
            $this->where(function (Builder $query) use ($attributes, $searchTerm) {
                $model = $query->getModel();
                $encryptableAttributes = method_exists($model, 'getEncryptableAttributes') ? $model->getEncryptableAttributes() : [];
                foreach (Arr::wrap($attributes) as $attribute) {
                    $query->when(
                        str_contains($attribute, '.'),
                        function (Builder $query) use ($attribute, $searchTerm) {
                            $buffer = explode('.', $attribute);
                            $attributeField = array_pop($buffer);
                            $relationPath = implode('.', $buffer);
                            $query->orWhereHas($relationPath, function (Builder $query) use ($attributeField, $searchTerm) {
                                $relationModel = $query->getModel();
                                $relationEncryptableAttributes = method_exists($relationModel, 'getEncryptableAttributes') ? $relationModel->getEncryptableAttributes() : [];

                                if (in_array($attributeField, $relationEncryptableAttributes) && method_exists($query, 'whereEncrypted')) {
                                    $query->whereEncrypted($attributeField, 'LIKE', "%{$searchTerm}%");
                                } else {
                                    $query->where($attributeField, 'LIKE', "%{$searchTerm}%");
                                }
                            });
                        },
                        function (Builder $query) use ($attribute, $searchTerm, $encryptableAttributes) {
                            if (in_array($attribute, $encryptableAttributes) && method_exists($query, 'orWhereEncrypted')) {
                                $query->orWhereEncrypted($attribute, 'LIKE', "%{$searchTerm}%");
                            } else {
                                $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
                            }
                        }
                    );
                }
            });
            return $this;
        });


        /**
         * Custom macro maskSensitiveData => Mask sensitive data with asterisk (*) in Laravel Collection
         * @param string|int|float $data
         * @param int $unmaskedStart opsional
         * @param int $unmaskedEnd opsional
         * @return string
         */
        Collection::macro('maskSensitiveData', function ($data, int $unmaskedStart = 2, int $unmaskedEnd = 2) {
            $dataString = (string)$data;
            $length = strlen($dataString);
            if ($length <= ($unmaskedStart + $unmaskedEnd)) {
                return $dataString;
            }
            $start = substr($dataString, 0, $unmaskedStart);
            $end = substr($dataString, -$unmaskedEnd);
            $masked = str_repeat('*', $length - $unmaskedStart - $unmaskedEnd);

            return $start . $masked . $end;
        });
    }


}
