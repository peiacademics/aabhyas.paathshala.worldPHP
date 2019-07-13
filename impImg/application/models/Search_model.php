<?php 
/**
* 
*/
class Search_model extends CI_model
{
	
	public function getData($searchTerm)
	{

		$data[] = $this->fetch_model->show(array('V'=> array('name LIKE'=>'%'.@$searchTerm.'%')));
		$data[] = $this->fetch_model->show(array('C'=> array('Name LIKE'=>'%'.@$searchTerm.'%')));
		$data[] = $this->fetch_model->show(array('P'=> array('name LIKE'=>'%'.@$searchTerm.'%')));
		$data[] = $this->fetch_model->show(array('M'=> array('model_name LIKE'=>'%'.@$searchTerm.'%')));
		$mainData=array_filter($data);
		foreach ($mainData as $key => $value) {
			foreach ($value as $k => $v)
              {
                if (strpos($v['ID'],'CS') !== false)
                { 
                	if(array_key_exists('Image_ID', $v))
                	{
                		$img = $this->str_function_library->call('fr>SS>path:ID=`'.$v['Image_ID'].'`');
                		$mainData[$key][$k]['Image_ID']=$img;
                	}
                	else
                	{
                		$mainData[$key][$k]['Image_ID']='impImg/main.jpg';
                	}
                }else if (strpos($v['ID'],'VS') !== false)
                {
                	if(array_key_exists('Image_ID', $v))
                	{
               			$img = $this->str_function_library->call('fr>SS>path:ID=`'.$v['Image_ID'].'`');
                		$mainData[$key][$k]['Image_ID']=$img;
                		// $value[$k]['Image_ID']=$img;
                	}
                	else
                	{
                		$mainData[$key][$k]['Image_ID']='impImg/main.jpg';
                	}
				}
				else if (strpos($v['ID'],'PS') !== false)
                {
                	$mdl = explode(',', $v['model_ID']);
                			$x='';
                	foreach ($mdl as $key1 => $value1)
                	{
                		if (!empty($value1))// != NULL)
                		{
                			$mod = $this->fetch_model->show(array('M'=>array('ID'=>$value1)));
                			foreach ($mod as $key2 => $value2)
                			{
                				$x.=$value2['model_name'].' , ';
/*                				echo "<pre>";
								var_dump($v['model_name']);
								echo "</pre>";
*/                			}
                		}
                	}                	
					$mainData[$key][$k]['model_name']= rtrim($x,', ');
					//var_dump(rtrim($x,', '));
                }
              }
		}
// print_r($data);
	return $mainData;
		// if (!empty($vdata))
		// {
		// 	return $vdata;
		// 	continue;
		// }
		// if (!empty($cdata))
		// {
		// 	return $cdata;
		// 	continue;

		// }
		// if (!empty($pdata))
		// {
		// 	return $pdata;
		// 	continue;

		// }
	}

	public function getDataJson($searchTerm)
	{

		$data[] = $this->fetch_model->show(array('V'=> array('name LIKE'=>'%'.@$searchTerm.'%')));
		$data[] = $this->fetch_model->show(array('C'=> array('name LIKE'=>'%'.@$searchTerm.'%')));
		$data[] = $this->fetch_model->show(array('P'=> array('name LIKE'=>'%'.@$searchTerm.'%')));
		$data[] = $this->fetch_model->show(array('M'=> array('model_name LIKE'=>'%'.@$searchTerm.'%')));
		$mainData=array_filter($data);
		foreach ($mainData as $key => $value) {
			foreach ($value as $k => $v)
              {
                if (strpos($v['ID'],'CS') !== false)
                { 
                	$img = $this->str_function_library->call('fr>SS>path:ID=`'.$v['Image_ID'].'`');
                	$mainData[$key][$k]['Image_ID']=$img;
                }else if (strpos($v['ID'],'VS') !== false)
                { 
               		$img = $this->str_function_library->call('fr>SS>path:ID=`'.$v['Image_ID'].'`');
                	$mainData[$key][$k]['Image_ID']=$img;
                	// $value[$k]['Image_ID']=$img;
				}
              }
		}
		header('Content-Type: application/x-json; charset=utf-8');
		// print_r($mainData);
		echo json_encode(array_filter($mainData));
		// if (!empty($vdata))
		// {
		// 	// var_dump($vdata);
		// 	echo json_encode(array("title"=>$vdata[0]['name'],"type"=>"vender","ID"=>$vdata[0]['ID']));
		// }
		// if (!empty($cdata))
		// {
		// 	echo json_encode(array("title"=>$cdata[0]['Name'],"type"=>"customer","ID"=>$cdata[0]['ID']));
		// }
		// if (!empty($pdata))
		// {
		// 	echo json_encode(array("title"=>$pdata[0]['Title'],"type"=>"Product","ID"=>$pdata[0]['ID']));
		// }
	}
}
?>