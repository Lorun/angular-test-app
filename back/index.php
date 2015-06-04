<?php 

$params = array('id', 'action');

$url = substr($_SERVER['REQUEST_URI'],strrpos($_SERVER['SCRIPT_NAME'],'/')+1);

list($id,$action) = explode('/',$url, 2);

$method = $_SERVER['REQUEST_METHOD'];

$result = array();

switch ($method) {
    case 'GET': // get list and item customer
        if($id == 'list')
        {
            $f = scandir('../data');
            foreach($f as $file)
            {
                if($file != '.' && $file != '..')
                {
                    $result[] = json_decode(file_get_contents('../data/'.$file));
                }
            }
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
        $new_id = '0'.($_id + 1);

        $data = json_decode($data);
        $data->id = $new_id;


        $fp = fopen("../data/".$new_id.".json", "w");
        fwrite($fp, json_encode($data));
        fclose($fp);
        exit();

        break;

    case 'POST': // edit customer
        $data = file_get_contents('php://input');

        if($id != '')
        {
            $fp = fopen("../data/".$id.".json", "w");
            fwrite($fp, $data);
            fclose($fp);
            $result = json_decode($data);
        }
        break;

    case 'DELETE': // delete customer
        unlink('../data/'.$id.'.json');
        $result['success'] = true;
        break;
}

echo json_encode($result);

?>