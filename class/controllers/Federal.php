<?php
/** Abstract Federal class structure to represent german federal states
 *
 * @url //https://de.wikipedia.org/wiki/Land_(Deutschland)#Gliederung_der_L%C3%A4nder
 * Class Federal
 */
abstract class Federal
{
    /**
     * @return int
     */
    abstract static function getId(): int;

    /**
     * @return string
     */
    abstract static function getShort(): string;

    /**
     * @return string
     */
    abstract static function getName(): string;

    /** create concrete federal state factory
     *
     * @param int $id
     * @return Federal
     */
    public static function createFederal(int $id): Federal
    {
        switch ($id)
        {
            case 10:
                return new NordrheinWestfalen();
                break;

            case 11:
                return new RheinlandPfalz();
                break;

            default:
                return new Sonstige();
        }
    }
}

class NordrheinWestfalen extends Federal
{
    /**
     * @return int
     */
    static function getId(): int
    {
        return 10;
    }

    /**
     * @return string
     */
    static function getShort(): string
    {
        return "NRW";
    }

    /**
     * @return string
     */
    static function getName(): string
    {
        return "Nordrhein-Westfalen";
    }
}

class RheinlandPfalz extends Federal
{
    /**
     * @return int
     */
    static function getId(): int
    {
        return 11;
    }

    //TODO: RLP zu RP umbenennen, überall!
    static function getShort(): string
    {
        return "RLP";
    }

    static function getName(): string
    {
        return "Rheinland-Pfalz";
    }
}

class Sonstige extends Federal
{
    /**
     * @return int
     */
    static function getId(): int
    {
        return 0;
    }

    /**
     * @return string
     */
    static function getShort(): string
    {
        return "SO";
    }

    /**
     * @return string
     */
    static function getName(): string
    {
        return "Sonstige";
    }
}