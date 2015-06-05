<?php 

$params = array('id', 'action');

$url = substr($_SERVER['REQUEST_URI'],strrpos($_SERVER['SCRIPT_NAME'],'/')+1);

list($id,$action) = explode('/',$url);

$method = $_SERVER['REQUEST_METHOD'];

$result = array();

switch ($method) {
    case 'GET': // get list and item customer
        if($id == 'list')
        {
            $result = getCustomers();
        }
        else
        {
            $result = json_decode(file_get_contents('../data/'.$id.'.json'));
        }
            
        break;

    case 'PUT': // create new customer
        $data = file_get_contents('php://input');

        $f = scandir('../data');
        $_id = (int)substr(array_pop($f), 0, -5);
        $new_id = $_id + 1;

        $data = json_decode($data);
        $data->id = $new_id;


        $fp = fopen("../data/".$new_id.".json", "w");
        fwrite($fp, json_encode($data));
        fclose($fp);
        exit();

        break;

    case 'POST': // edit customer
        $data = file_get_contents('php://input');
        $data_arr = json_decode($data);

        if($action == 'checkUnique' && isset($data_arr->property))
        {
            

            $result['status'] = true;
            $customers = getCustomers();
            foreach ($customers as $item)
            {
                if ($item->id != $id && $item->{$data_arr->property} == $data_arr->value)
                    $result['status'] = false;
            }
        }
        else
        {
            if($id != '' && $id != 0)
            {
                $fp = fopen("../data/".$id.".json", "w");
                fwrite($fp, $data);
                fclose($fp);
                $result = json_decode($data);
            }
        }

        break;

    case 'DELETE': // delete customer
        unlink('../data/'.$id.'.json');
        $result['success'] = true;
        break;
}

function getCustomers()
{
    $arr = array();
    $f = scandir('../data');

    foreach($f as $file)
    {
        if($file != '.' && $file != '..')
        {
            $arr[] = json_decode(file_get_contents('../data/'.$file));
        }
    }
    return $arr;
}

echo json_encode($result);

?>