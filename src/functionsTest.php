
<?php
/* -------------------------------------------------------------------- */
/* FILE : functionsTest.php
 * aims to test the functions present in
 *
 * Author : Amin, Simon
 * ------------------------------------------------------------------ */


use vendor\phpunit\phpunit\tests\Framework\TestCase;
require_once 'functions.php';
/* use PHPUnit\Framework\TestCase */

class FunctionsTest extends \PHPUnit_Framework_TestCase
{
     public function testDecodeFileValid() {
      $var1 = "../db/users.txt";
      $var2 = "../db/empty.txt";

      // if a file is empty, the result array should be [] which is considered
      // as NULL in php

      $this->assertNotNull(DecodeFile($var1));
      $this->assertNull(DecodeFile($var2));
     }

     // the following comment allows phpunit to test warnings. As DecodeFile()
     // throws an E_WARNING when a non-existent file is passed, we "catch" it
     // with @expectedEception. A success on this test stands for a catched
     // exception.

     /**
     * @expectedException PHPUnit_Framework_Error_Warning
     */
     public function testDecodeFileNonValid() {
       $var1 = "pouet.txt";
       DecodeFile($var1);

     }

     public function testExistUser() {
       $tmp_file = "file.txt";
       $handle = fopen($tmp_file, 'w') or die("Can't create file");
       fclose($handle);
       EncodeUser("Neige", "Password", "file.txt");

       $log1 = "Jezabel";
       $log2 = "Neige";

       $this->assertEquals(false, ExistUser($log1, $tmp_file));
       $this->assertEquals(true, ExistUser($log2, $tmp_file));

       unlink($tmp_file);
     }

     public function testValidUser() {
       $tmp_file = "file.txt";
       $handle = fopen($tmp_file, 'w') or die("Can't create file");
       fclose($handle);
       EncodeUser("Neige", "Password", "file.txt");

       $log1 = "Neige";
       $log2 = "Jezabel";
       $pwd1 = "Password";
       $pwd2 = "Pouet";

       $this->assertEquals(true, ValidUser($log1, $pwd1, $tmp_file));
       $this->assertEquals(false, ValidUser($log2, $pwd2, $tmp_file));
       $this->assertEquals(false, ValidUser($log1, $pwd2, $tmp_file));

       unlink($tmp_file);

     }



}

 ?>
