<?php

namespace Cheezykins\StringIncrementer;

use Cheezykins\StringIncrementer\Exceptions\InvalidSymbolException;

class IncrementalString
{
    const DEFAULT_ALPHABET = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';

    protected $alphabet;
    protected $current;
    protected $alphabetLength;
    protected $position;

    /**
     * IncrementalString constructor.
     *
     * @param string      $start
     * @param string|null $alphabet
     *
     * @throws InvalidSymbolException
     */
    public function __construct($start = '', $alphabet = null)
    {
        if ($alphabet === null) {
            $alphabet = self::DEFAULT_ALPHABET;
        }
        if ($start !== '' && !self::verifyAgainstAlphabet($start, $alphabet)) {
            throw new InvalidSymbolException('The start string contains invalid characters');
        }
        $this->setAlphabet($alphabet);
        $this->setCurrentString($start);
    }

    /**
     * Validates that the given string is valid against the given alphabet.
     *
     * @param $string string
     * @param $alphabet string|string[]
     *
     * @return bool
     */
    protected static function verifyAgainstAlphabet($string, $alphabet)
    {
        $elements = \str_split($string);
        if (!\is_array($alphabet)) {
            $alphabet = \str_split($alphabet);
        }
        foreach ($elements as $element) {
            if (!in_array($element, $alphabet)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $alphabet
     */
    public function setAlphabet($alphabet)
    {
        $this->alphabet = \str_split($alphabet);
        $this->alphabetLength = \count($this->alphabet);
        $this->setCurrentString('');
    }

    /**
     * @param string $start
     *
     * @throws InvalidSymbolException
     */
    public function setCurrentString($start)
    {
        if ($start !== '' && !self::verifyAgainstAlphabet($start, $this->alphabet)) {
            throw new InvalidSymbolException('The given string contains invalid characters');
        }

        if ($start === '') {
            $start = $this->alphabet[0];
        }
        $this->current = \str_split($start);
        $this->setPosition();
    }

    /**
     * Sets the position in the alphabet based on a start string.
     */
    protected function setPosition()
    {
        $this->position = \array_search(end($this->current), $this->alphabet);
    }

    /**
     * Increment the current string by a given number of times and returns
     * the new value.
     *
     * @param int $amount
     *
     * @return string
     */
    public function increment($amount = 1)
    {
        for ($i = 0; $i < $amount; $i++) {
            $this->current = $this->incrementArray($this->current);
        }

        return $this->output();
    }

    /**
     * Increments the internal array.
     *
     * @param array|null $array
     *
     * @return array
     */
    protected function incrementArray($array)
    {
        $length = \count($array);

        if ($length == 0) {
            return [$this->alphabet[0]];
        }

        $value = \array_pop($array);
        $key = \array_search($value, $this->alphabet);
        $key++;
        if (!array_key_exists($key, $this->alphabet)) {
            $key = 0;
            $array = $this->incrementArray($array);
        }
        $array[] = $this->alphabet[$key];

        return $array;
    }

    /**
     * Returns the output but padded to length characters using the start of the
     * given alphabet.
     *
     * @param $length
     *
     * @return string
     */
    public function padOutput($length)
    {
        return \str_pad($this->output(), $length, $this->alphabet[0], STR_PAD_LEFT);
    }

    /**
     * Returns the current string.
     *
     * @return string
     */
    public function output()
    {
        return \implode('', $this->current);
    }

    /**
     * Magic method allowing casting to string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->output();
    }
}
