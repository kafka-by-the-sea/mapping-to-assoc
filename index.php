<?php
use Illuminate\Support\Collection;
require_once 'vendor/autoload.php';

//原本的input
$employees = [
    [
        'name' => 'John',
        'department' => 'Sales',
        'email' => 'john@example.com'
    ], 
    [
        'name' => 'Jane',
        'department' => 'Marketing',
        'email' => 'jane@example.com'
    ],
    [
        'name' => 'Dave',
        'department' => 'Marketing',
        'email' => 'dave@example.com'
    ],
];

//期望的output
$emailLookup = [
    'john@example.com' => 'John',
    'jane@example.com' => 'Jane',
    'dave@example.com' => 'Dave',
];

$emailLookup = collect($employees)->reduce(function ($emailLookup, $employee) {
    $emailLookup[$employee['email']] = $employee['name'];
    return $emailLookup;
}, []);

//dd($emailLookup);

Collection::macro('toAssoc', function () {
    return $this->reduce(function ($assoc, $keyValuePair) {
        list($key, $value) = $keyValuePair;
        $assoc[$key] = $value;
        return $assoc;
    }, new static);
});

Collection::macro('mapToAssoc', function ($callback) {
    return $this->map($callback)->toAssoc();
});

$emailLookup = collect($employees)->mapToAssoc(function ($employee) {
    return [$employee['email'], $employee['name']];
});

dd($emailLookup);