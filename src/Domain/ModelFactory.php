<?php

namespace Orqlog\YacampaignDraw\Domain;

class ModalFactory
{

    public static function make(string $class, array $data, array $constructArgs=[]): object
    {
        if (count($constructArgs)<1) {
            $obj = new $class();
        } else {
            $r = new \ReflectionClass($class);
            $obj = $r->newInstanceArgs($constructArgs);
        }
        try {
            foreach ($data as $k => $v) {
                if (!is_null($v)) {
                    $k = self::toProperty($k);
                    $setter = 'set' . ucfirst($k);
                    if ($obj->hasMethod($setter)) {
                        $obj->{$setter}($v);
                    }
                }
            }
        } catch(DomainException $e) {
            throw $e;
        }

        $validatorClass = $class.'Validator';
        if (class_exists($validatorClass)) {
            $validator = new $validatorClass();
            try {
                $validator->validate($obj);
            } catch (DomainException $e) {
                throw $e;
            }
        }
        return $obj;
    }

        /**
     * Substitute 'cover_image' to 'coverImage'
     */
    static function toProperty(string $k): string
    {
        if (strpos($k, '_')) {
            $k = preg_replace_callback('/_([a-z])/', function ($matches) {
                return strtoupper($matches[1]);
            }, $k);
        }
        return $k;
    }

    /**
     * Substitute 'coverImage' to 'cover_image'
     */
    static function toField(string $str): string
    {
        $str = lcfirst($str);
        $str = preg_replace_callback('/([A-Z])/', function ($matches) {
            return '_' . strtolower($matches[0]);
        }, $str);

        return $str;
    }
}
