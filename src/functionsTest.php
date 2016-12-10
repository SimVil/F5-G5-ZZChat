
<?php
/* ------------------------------------------------------------------ */
/* FILE : functionsTest.php
 * aims to test the functions present in functions.php
 *
 * Author : Amin, Simon
 * ------------------------------------------------------------------ */


// first use : windows (XAMPP)
// second one : Unix (centOS)
// use vendor\phpunit\phpunit\tests\Framework\TestCase;
require_once 'functions.php';
use PHPUnit\Framework\TestCase;

class FunctionsTest extends \PHPUnit_Framework_TestCase
{

    // 1 - DecodeFile [1]. Assertions :
    //     empty file               --> null array
    //     non-empty valid file     --> not null array
    public function testDecodeFile1() {
      $file1 = "file1.txt";
      $file2 = "file2.txt";
      touch($file1);
      touch($file2);

      EncodeUser("jezabel", "reine", $file1);

      // if a file is empty, the result array should be [] which is considered
      // as NULL in php

      $this->assertNotNull(DecodeFile($file1));
      $this->assertNull(DecodeFile($file2));

      unlink($file1);
      unlink($file2);
    }



     // the following comment allows phpunit to test warnings. As DecodeFile()
     // throws an E_WARNING when a non-existent file is passed, we "catch" it
     // with @expectedEception. A success on this test stands for a catched
     // exception.


     // 2 - DecodeFile [2]. Assertions :
     //     non existent file --> exception

     /**
     * @expectedException PHPUnit_Framework_Error_Warning
     */
     public function testDecodeFile2() {
       $file = "pouet.txt";
       DecodeFile($file);

     }



    // 3 - DecodeFile [3]. Assertions :
    //     existent non-valid file --> null array
    public function testDecodeFile3() {
        $file = "file.txt";
        touch($file);
        $handle = fopen($file, 'w');
        if($handle){
        	fwrite($handle, "the pox on you and your kind !");
        	$this->assertNull(DecodeFile($file));
        	fclose($handle);
        }

        unlink($file);
    }



    // 4 - ExistUser [1]. Assertions :
    //     existent user     --> true
    //     non existent user --> false
    public function testExistUser() {
        $file = "file.txt";
        touch($file);
        EncodeUser("Neige", "Password", $file);

        $log1 = "Jezabel";
        $log2 = "Neige";

        $this->assertEquals(false, ExistUser($log1, $file));
        $this->assertEquals(true, ExistUser($log2, $file));

        unlink($file);
    }



    // 5 - ValidUser [1]. Assertions :
    //     valid (log, pwd)     --> true
    //     non-valid (log, pwd) --> false
    //     log xor pwd          --> false
    public function testValidUser() {
        $file = "file.txt";
        touch($file);
        EncodeUser("Neige", "Password", $file);

        $log1 = "Neige";
        $log2 = "Jezabel";
        $pwd1 = "Password";
        $pwd2 = "Pouet";

        $this->assertEquals(true, ValidUser($log1, $pwd1, $file));
        $this->assertEquals(false, ValidUser($log2, $pwd2, $file));
        $this->assertEquals(false, ValidUser($log1, $pwd2, $file));

        unlink($file);

    }



    // notice that this function use DecodeFile(), in which we have
    // already tested the E_WARNING. So it is not a specific case
    // for EncodeUser().

    // 6 - EncodeUser [1]. Assertions :
    //     effective encoding --> true
    //     not null array after encoding
    //     login encoded
    //     pass not encoded without hash
    //     pass hashed with SHA256
    public function testEncodeUser1() {
        $log = "Jezabel";
        $pwd = "Infini";

        $file = "file.txt";
        touch($file);
        $this->assertTrue(EncodeUser($log, $pwd, $file));

        $arr = DecodeFile($file);
        $this->assertNotNull($arr);
        $this->assertEquals($log, $arr[0]["login"]);
        $this->assertNotEquals($pwd, $arr[0]["pass"]);
        $this->assertEquals(hash("sha256", "$pwd"), $arr[0]["pass"]);

        unlink($file);

    }



    // 7 - EncodeUser [2]. Assertions :
    //     cannot encode an user twice
    //     encoding is restrictive on log
    //     encoding is not restrictive on pass
    public function testEncodeUser2(){
        $log = "Jezabel";
        $pwd = "Infini";

        $file = "file.txt";
        touch($file);
        EncodeUser($log, $pwd, $file);
        $this->assertFalse(EncodeUser($log, $pwd, $file));
        $this->assertFalse(EncodeUser($log, "Aleph", $file));
        $this->assertTrue(EncodeUser("Hermine", $pwd, $file));

        unlink($file);
    }



    // 8 - ReadOnlineArray [1]. Assertions :
    //     non empty file --> not null array
    public function testReadOnlineArray1(){
        $file = file_writing();
        $this->assertNotNull(ReadOnlineArray($file));
        unlink($file);

    }



    // 9 - ReadOnlineArray [2]. Assertions :
    //     empty file --> null array
    public function testReadOnlineArray2(){
        $file = "file.txt";
        touch($file);

        $this->assertNull(ReadOnlineArray($file));
        unlink($file);
    }


    // 10 - ReadOnlineArray [3]. Assertions :
    //      non existent file --> exception

    /**
    * @expectedException PHPUnit_Framework_Error_Warning
    */
    public function testReadOnlineArray3(){
        $file = "file.txt";
        ReadOnlineArray($file);
    }


    // 11 - array_find [1]. Assertions :
    //      find a log encoded       --> login key
    //      find a non encoded value --> false
    public function testarray_find1(){
        $it1 = array("login" => "Jezabel", "pass" => "david");
        $it2 = array("login" => "Halcyon", "pass" => "davidon");

        $arr[] = $it1;
        array_push($arr, $it2);

        $this->assertEquals('login', array_find($arr, "Jezabel"));
        $this->assertEquals('login', array_find($arr, "Halcyon"));
        $this->assertEquals(false, array_find($arr, "Michou"));

    }



    // 12 - array_find [2]. Assertions :
    //      find a value in null array --> exception
    /**
    * @expectedException PHPUnit_Framework_Error_Warning
    */
    public function testarray_find2(){
        $arr[] = NULL;
        array_find($arr, "Jezabel");
    }



    // 13 - checkVarReg [1]. Assertions :
    //      5 char long log              --> true
    //      letters and numbers          --> true
    //      upper/lower case and numbers --> true
    public function testcheckVarReg1(){
        $var1 = "david";
        $var2 = "jezabel24";
        $var3 = "AzeRttu196";

        $this->assertEquals(true, checkVarReg($var1));
        $this->assertEquals(true, checkVarReg($var2));
        $this->assertEquals(true, checkVarReg($var3));
    }



    // 14 - checkVarReg [2]. Assertions :
    //      empty string      --> false
    //      < 5 char long     --> false
    //      special chars (!) --> false
    //      > 15 char long    --> false
    public function testcheckVarReg2(){
        $var1 = "";
        $var2 = "123";
        $var3 = "david!!";
        $var4 = "123456789abcdefr17";

        $this->assertEquals(false, checkVarReg($var1));
        $this->assertEquals(false, checkVarReg($var2));
        $this->assertEquals(false, checkVarReg($var3));
        $this->assertEquals(false, checkVarReg($var4));

    }


    // 15 - IsConnected [1]. Assertions :
    //      log present in file --> true
    //      not present in file --> false
    public function testIsConnected1(){
        $file = file_writing();

        $this->assertEquals(true, IsConnected("jezabel", $file));
        $this->assertEquals(false, IsConnected("Emily", $file));

        unlink($file);
    }


    // 16 - IsConnected [2]. Assertions :
    //      non-existent file --> expectedException
    /**
    * @expectedException PHPUnit_Framework_Error_Warning
    */
    public function testIsConnected2(){
        IsConnected("jezabel", "file.txt");
    }



    // 17 - GetConnected [1]. Assertions :
    //      already written name --> false
    //      non written name     --> true
    public function testGetConnected1(){
        $file = file_writing();

        $this->assertEquals(false, GetConnected("jezabel", $file));
        $this->assertEquals(true, GetConnected("cocteau twins", $file));

        unlink($file);
    }



    // 18 - smileys [1]. Assertions :
    //      a text with :) symbols is changed
    //      a text without is not
    public function testsmiley1(){
        $text1 = ":@ Hello there :) !";
        $text2 = "Hello there !";

        $this->assertEquals($text2, smileys($text2));
        $this->assertNotEquals($text1, smileys($text1));
    }


}


// this is just a function to avoid code duplication. It is
// only used in this file to get a suitable context for tests
function file_writing(){
		$list = "jezabel"."\n"."Neige"."\n"."Aurore";
		$file = "file.txt";
		touch($file);
		$fp = fopen($file, 'w');
		fwrite($fp, $list);
		fclose($fp);
		return $file;
}

 ?>
