<?php
/**
 * This file has been @generated by a phing task by {@link BuildMetadataPHPFromXml}.
 * See [README.md](README.md#generating-data) for more information.
 *
 * Pull requests changing data in these files will not be accepted. See the
 * [FAQ in the README](README.md#problems-with-invalid-numbers] on how to make
 * metadata changes.
 *
 * Do not modify this file directly!
 */


return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '[12469]\\d{2,5}',
    'PossibleLength' => 
    array (
      0 => 3,
      1 => 4,
      2 => 5,
      3 => 6,
    ),
    'PossibleLengthLocalOnly' => 
    array (
    ),
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '1(?:00|[89]\\d)|4(?:57|828)',
    'ExampleNumber' => '181',
    'PossibleLength' => 
    array (
      0 => 3,
      1 => 4,
    ),
    'PossibleLengthLocalOnly' => 
    array (
    ),
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleLength' => 
    array (
      0 => -1,
    ),
    'PossibleLengthLocalOnly' => 
    array (
    ),
  ),
  'emergency' => 
  array (
    'NationalNumberPattern' => '1(?:12|28|9[023])|911',
    'ExampleNumber' => '190',
    'PossibleLength' => 
    array (
      0 => 3,
    ),
    'PossibleLengthLocalOnly' => 
    array (
    ),
  ),
  'shortCode' => 
  array (
    'NationalNumberPattern' => '1(?:0(?:[02]|3(?:1[2-579]|2[13-9]|3[124-9]|4[1-3578]|5[1-468]|6[139]|8[149]|9[168])|5[0-35-9]|6(?:0|1[0-35-8]?|2[0145]|3[0137]?|4[37-9]?|5[0-35]|6[016]?|7[137]?|8[5-8]|9[1359]))|1[5-8]|2[35789]|3(?:[024568]|3[12])|4[12568]|5\\d|6[0-8]|8[015]|9[0-4789])|2(?:7(?:330|878)|85959?)|4(?:0404?|11[12]|57|828)|55555|6(?:0(?:5(?:0(?:0[1-9]|[1-9]\\d)|[1-9]\\d{2})|[6-9]\\d{3})|10000)|911',
    'ExampleNumber' => '168',
    'PossibleLength' => 
    array (
    ),
    'PossibleLengthLocalOnly' => 
    array (
    ),
  ),
  'standardRate' => 
  array (
    'NationalNumberPattern' => '102|27330',
    'ExampleNumber' => '27330',
    'PossibleLength' => 
    array (
      0 => 3,
      1 => 5,
    ),
    'PossibleLengthLocalOnly' => 
    array (
    ),
  ),
  'carrierSpecific' => 
  array (
    'NationalNumberPattern' => '27878|4(?:0404?|11[12]|57)|55555',
    'ExampleNumber' => '27878',
    'PossibleLength' => 
    array (
      0 => 3,
      1 => 4,
      2 => 5,
    ),
    'PossibleLengthLocalOnly' => 
    array (
    ),
  ),
  'id' => 'BR',
  'countryCode' => 0,
  'internationalPrefix' => '',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
  ),
  'intlNumberFormat' => 
  array (
  ),
  'mainCountryForCode' => false,
  'leadingZeroPossible' => false,
  'mobileNumberPortableRegion' => false,
);
