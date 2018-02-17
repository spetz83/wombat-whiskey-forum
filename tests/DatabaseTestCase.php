<?php
////////////////////
//
// Copyright 2014-2016. Quantum Corporation. All Rights Reserved.
// StorNext is either a trademark or registered trademark of
// Quantum Corporation in the US and/or other countries.
//
////////////////////

namespace Tests;


use Illuminate\Foundation\Testing\DatabaseMigrations;

abstract class DatabaseTestCase extends TestCase
{
    use DatabaseMigrations;
}