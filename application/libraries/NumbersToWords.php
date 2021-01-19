<?php

  class NumbersToWords{
    
    public static $hyphen      = '-';
    public static $conjunction = ' and ';
    public static $separator   = ', ';
    public static $negative    = 'negative ';
    public static $decimal     = ' point ';
    public static $dictionary  = array(
      0                   => 'zero',
      1                   => 'first',
      2                   => 'second',
      3                   => 'third',
      4                   => 'fourth',
      5                   => 'fiveth',
      6                   => 'sixth',
      7                   => 'seventh',
      8                   => 'eighth',
      9                   => 'nineth',
      10                  => 'tenth',
      11                  => 'eleventh',
      12                  => 'twelfth',
      13                  => 'thirteenth',
      14                  => 'fourteenth',
      15                  => 'fifteenth',
      16                  => 'sixteenth',
      17                  => 'seventeenth',
      18                  => 'eighteenth',
      19                  => 'nineteenth',
      20                  => 'twentieth',
      30                  => 'thirtieth',
      40                  => 'fourtieth',
      50                  => 'fiftieth',
      60                  => 'sixtieth',
      70                  => 'seventieth',
      80                  => 'eightieth',
      90                  => 'ninetieth',
      100                 => 'hundred',
      1000                => 'thousand',
      1000000             => 'million',
      1000000000          => 'billion',
      1000000000000       => 'trillion',
      1000000000000000    => 'quadrillion',
      1000000000000000000 => 'quintillion'
    );

    public static function convert($number){
      if (!is_numeric($number) ) return false;
      $string = '';
      switch (true) {
        case $number < 21:
            $string = self::$dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = self::$dictionary[$tens];
            if ($units) {
                $string .= self::$hyphen . self::$dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = self::$dictionary[$hundreds] . ' ' . self::$dictionary[100];
            if ($remainder) {
                $string .= self::$conjunction . self::convert($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = self::convert($numBaseUnits) . ' ' . self::$dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? self::$conjunction : self::$separator;
                $string .= self::convert($remainder);
            }
            break;
      }
      return $string;
    }
  }//end class
?>