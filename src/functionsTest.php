
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

     /**
     * @expectedException PHPUnit_Framework_Error_Warning
     */
     public function testDecodeFile2() {
       $file = "pouet.txt";
       DecodeFile($file);

     }
     
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
	
	public function testEncodeUser2(){
		$log = "Jezabel";
		$pwd = "Infini";
		
	    $file = "file.txt";
        touch($file);
        EncodeUser($log, $pwd, $file);
        $this->assertFalse(EncodeUser($log, $pwd, $file));
        $this->assertFalse(EncodeUser($log, "Aleph", $file));
        
        unlink($file);
	}
	
	
	public function testReadOnlineArray1(){
		$file = file_writing();
		$this->assertNotNull(ReadOnlineArray($file));
		unlink($file);
		
	}
	
	public function testReadOnlineArray2(){
		$file = "file.txt";
		touch($file);
		
		$this->assertNull(ReadOnlineArray($file));
		unlink($file);
	}
	
	
	/**
     * @expectedException PHPUnit_Framework_Error_Warning
     */
	public function testReadOnlineArray3(){
		$file = "file.txt";
		ReadOnlineArray($file);
	}
	
	
	public function testarray_find1(){
		$it1 = array("login" => "Jezabel", "pass" => "david");
		$it2 = array("login" => "Halcyon", "pass" => "davidon");
		
		$arr[] = $it1;
		array_push($arr, $it2);
		
		$this->assertEquals('login', array_find($arr, "Jezabel"));
		$this->assertEquals('login', array_find($arr, "Halcyon"));
		$this->assertEquals(false, array_find($arr, "Michou"));

	}
	
	
	/**
     * @expectedException PHPUnit_Framework_Error_Warning
     */
	public function testarray_find2(){
		$arr[] = NULL;
		$this->assertEquals(false, array_find($arr, "Jezabel"));
	}
	
	
	public function testcheckVarReg1(){
		$var1 = "david";
		$var2 = "jezabel24";
		$var3 = "AzeRttu196";
		
		$this->assertEquals(true, checkVarReg($var1));
		$this->assertEquals(true, checkVarReg($var2));
		$this->assertEquals(true, checkVarReg($var3));
	}
	
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
	
	public function testIsConnected1(){
		$file = file_writing();
		
		$this->assertEquals(true, IsConnected("jezabel", $file));
		$this->assertEquals(false, IsConnected("Emily", $file));
		
		unlink($file);
	}
	
	
	/**
    * @expectedException PHPUnit_Framework_Error_Warning
    */
	public function testIsConnected2(){
		IsConnected("jezabel", "file.txt");
	}
	
	
	
	public function testGetConnected1(){
		$file = file_writing();
		
		$this->assertEquals(false, GetConnected("jezabel", $file));
		$this->assertEquals(true, GetConnected("cocteau twins", $file));
		
		unlink($file);
	}
	
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
