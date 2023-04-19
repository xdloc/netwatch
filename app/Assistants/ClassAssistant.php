<?php

namespace App\Assistants;

use App\Weapons\WeaponInterface;
use Illuminate\Support\Facades\Cache;
use ReflectionException;

class ClassAssistant
{
    private const DETECTIVE = 'Detective';
    private const WEAPON = 'Weapon';

    /**
     * Get declared classes
     * @return string[]
     */
    public static function getDeclaredClasses(): array
    {
        if (Cache::has('declared_classes')) {
            $declaredClasses = Cache::get('declared_classes');
        } else {
            $declaredClasses = get_declared_classes();
            Cache::put('declared_classes', $declaredClasses, 3600);
        }
        return $declaredClasses;
    }

    /**
     * Get all weapons or weapons for required detective
     * @param string|array|null $detective Detective Classname[s] or null for all
     * @return WeaponInterface[]
     */
    public static function getWeapons(string|array|null $detective = null): array
    {
        $allWeapons = [];
        $allDetectives = [];

        $requiredDetectives = is_array($detective) ? $detective : [$detective];

        foreach (self::getDeclaredClasses() as $class) {
            if (self::isDetectiveClass($class)
                && $detective !== null
                && in_array($class, $requiredDetectives, true)) {
                $allDetectives[] = self::removeClassDetermination($class, self::DETECTIVE);
            }
            try {
                if (self::isWeaponClass($class)) {
                    $allWeapons[] = $class;
                }
            } catch (ReflectionException $exception) {
                \Sentry\captureException($exception);
            }
        }

        if ($detective === null) {
            return $allWeapons;
        }
        unset($detective);

        $detectiveWeapons = [];
        foreach ($allWeapons as $weapon) {
            foreach ($allDetectives as $detective) {
                if (self::isWeaponOwner($weapon, $detective)) {
                    $detectiveWeapons[] = $weapon;
                }
            }
        }
        return $detectiveWeapons;
    }

    /**
     * @return array
     */
    public static function getDetectives(): array
    {
        $allDetectives = [];
        foreach (self::getDeclaredClasses() as $class) {
            if (self::isDetectiveClass($class)) {
                $allDetectives[] = self::removeClassDetermination($class, self::DETECTIVE);
            }
        }
        return $allDetectives;
    }

    /**
     * @param string $classname
     * @return bool
     */
    public static function isDetectiveClass(string $classname): bool
    {
        $detectiveLength = mb_strlen(self::DETECTIVE);
        return mb_substr($classname, -$detectiveLength, $detectiveLength) === self::DETECTIVE;
    }

    /**
     * Check the weapon based on it namespace App\Weapons
     * @param string $classname
     * @return bool
     * @throws ReflectionException
     */
    public static function isWeaponClass(string $classname): bool
    {
        $reflectionClass = new \ReflectionClass($classname);
        $namespace = $reflectionClass->getNamespaceName();
        $weaponsLength = mb_strlen(self::WEAPON . 's');
        return mb_substr($namespace, -$weaponsLength, $weaponsLength) === self::WEAPON . 's';
    }

    /**
     * @param string $classname
     * @param string $determination
     * @return string
     */
    public static function removeClassDetermination(string $classname, string $determination): string
    {
        $determinationLength = mb_strlen($determination);
        return substr_replace($classname, '', -$determinationLength);
    }

    /**
     * @param string $weaponClassname
     * @param string $detective name without class
     * @return bool
     */
    public static function isWeaponOwner(string $weaponClassname, string $detective): bool
    {
        $detectiveLength = mb_strlen($detective);
        $weaponClassnameOnset = mb_substr($weaponClassname, 0, $detectiveLength);
        return $weaponClassnameOnset === $detective;
    }

    /**
     * @param string $weapon
     * @return string|null detective name or null
     */
    public static function getDetective(string $weapon): ?string
    {
        $allDetectives = self::getDetectives();
        foreach ($allDetectives as $detective) {
            if (self::isWeaponOwner($weapon, $detective)) {
                return $detective;
            }
        }
        return null;
    }
}
