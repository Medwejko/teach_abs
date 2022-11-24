<?php


include_once 'config.php';
/**
 * API приложения
 * api::saveObj($class,$data);
 * api::saveObj($param);
 * $param = array('class'=>'user','data'=>array('id'=>1));

 */

main::printr($_REQUEST);



if(isset($_REQUEST['delete']))
{
	$result = api::delete($_REQUEST['obj'],$_REQUEST['id']);
	echo json_encode($result,JSON_UNESCAPED_UNICODE);
}
else if(isset($_REQUEST['dynamicSelect']))
{
	$result = api::dynamicSelect($_REQUEST['class'],$_REQUEST['properties'],$_REQUEST['mask']);
	echo json_encode($result,JSON_UNESCAPED_UNICODE);

}
else if(isset($_REQUEST['dynamicSelectTask']))
{
	$result = api::dynamicSelectTask($_REQUEST['class'],$_REQUEST['properties'],$_REQUEST['mask']);
	echo json_encode($result,JSON_UNESCAPED_UNICODE);

}
else if(isset($_REQUEST['dynamicSelectResult']))
{
	$result = api::dynamicSelectResult($_REQUEST['class'],$_REQUEST['properties'],$_REQUEST['mask']);
	echo json_encode($result,JSON_UNESCAPED_UNICODE);

}
else if(isset($_REQUEST['endTask']))
{
	$result = api::endTask($_REQUEST['task'],$_REQUEST['user']);
	echo json_encode($result,JSON_UNESCAPED_UNICODE);

}
else if(isset($_REQUEST['result']))
{
	$result = api::saveResult($_REQUEST['result'],$_REQUEST['user'],json_decode($_REQUEST['data'], true));
	echo '{"status":"ok"}';
}
else
{
	$obj = api::obj($_REQUEST['obj'],json_decode($_REQUEST['data'], true));

	if(isset($obj->id))
	{
		echo '{"status":"ok"}';
	};
};
?>