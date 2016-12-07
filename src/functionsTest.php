
<?php
/* -------------------------------------------------------------------- */
/* FILE : functionsTest.php
 * aims to test the functions present in
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
      $var1 = "../db/users.txt";
      $var2 = "../db/empty.txt";

      // if a file is empty, the result array should be [] which is considered
      // as NULL in php
	
	  /*
	  if(filesize($var1) !== 0){
		  print(filesize($var1));
		  $this->assertNotNull(DecodeFile($var1));
	  } else {
		  $this->assertNull(DecodeFile($var1));
	  }
	  */ 
	 
      $this->assertNull(DecodeFile($var2));
     }

     // the following comment allows phpunit to test warnings. As DecodeFile()
     // throws an E_WARNING when a non-existent file is passed, we "catch" it
     // with @expectedEception. A success on this test stands for a catched
     // exception.

     /**
     * @expectedException PHPUnit_Framework_Error_Warning
     */
     public function testDecodeFile2() {
       $var1 = "pouet.txt";
       DecodeFile($var1);

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

}


 ?>
