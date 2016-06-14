# StringIncrementer
An arbitrary symbol and precision string incrementer.

[![Build Status](https://travis-ci.org/Cheezykins/StringIncrementor.svg?branch=master)](https://travis-ci.org/Cheezykins/StringIncrementor)

Usage is very simple.

```php

<?php

// Import and use
use Cheezykins\StringIncrementer\IncrementalString;
$inc = new IncrementalString();

// Basic usage
echo $inc; // displays a
$inc->increment();
echo $inc; // displays b
echo $inc->increment(3); // displays e

// Set the current string
$inc->setCurrentString('abcd0');
echo $inc->increment(); // displays abcea

// Set an arbitrary alphabet
$inc->setAlphabet('0123456789abcdef');
echo $inc; // displays 0
echo $inc->increment(20) // displays 04


// Set an arbitrary start and alphabet at declaration
$inc = new IncrementalString('sgrpa', 'abcdefghijklmnopqrs');
```