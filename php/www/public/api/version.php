 
<?php

$system = $_POST['system'];
//安卓
if($system=="0"){
	$array = array( 
                         'newVersion'=>"1"   ,  
						   'url'=>"http://fir.im/gubt",
						   'info'=>"update info",
						   'statue'=>"0"
						   );
						   echo json_encode($array);
	
}else {
	//$array = array( 
          //                 'newVersion'=>"6", 
			//			   'url'=>"http://pre.im/zpe5",
			//			   'info'=>"修复好友申请通知失效,请重新登陆",
				//		   'statue'=>"1"
				//		   );
						   
$array = array( 
                           'newVersion'=>"1"   ,  
						   'url'=>"https://www.pgyer.com/9sVQ",
						   'info'=>'修复好友申请通知失效,请重新登陆',
						   'statue'=>"1"
						   );
						   echo json_encode($array);						   
						   
						  // $array = array( 
                         //  'newVersion'=>"5"   ,  
						 //  'url'=>"http://pre.im/zpe5",
						 //  'statue'=>"1"
						 //  );
						 //  echo json_encode($array);
 	
}

 


?>